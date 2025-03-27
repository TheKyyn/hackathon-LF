<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class TrackingService
{
    protected $agent;
    protected $request;

    /**
     * Constructeur avec injection de dépendances.
     */
    public function __construct(Request $request)
    {
        $this->agent = new Agent();
        $this->request = $request;
    }

    /**
     * Crée ou récupère une visite pour la session courante.
     *
     * @return Visit|null
     */
    public function trackVisit(): ?Visit
    {
        try {
            // Récupérer les données de la session si elles existent
            $visitId = session()->get('visit_id');
            $visit = null;

            Log::debug('Début du tracking de visite', [
                'session_id' => session()->getId(),
                'session_visit_id' => $visitId
            ]);

            if ($visitId) {
                $visit = Visit::find($visitId);
                if ($visit) {
                    Log::debug('Visite existante trouvée en session', [
                        'visit_id' => $visit->id,
                        'created_at' => $visit->created_at
                    ]);
                } else {
                    Log::warning('ID de visite trouvé en session mais introuvable en base', [
                        'session_visit_id' => $visitId
                    ]);
                }
            } else {
                Log::debug('Aucune visite trouvée en session', [
                    'session_data' => collect(session()->all())->keys()->toArray()
                ]);
            }

            // Si aucune visite n'est trouvée, créer une nouvelle
            if (!$visit) {
                try {
                    Log::debug('Création d\'une nouvelle visite');
                    $visit = $this->createNewVisit();
                    session()->put('visit_id', $visit->id);
                    Log::debug('Nouvelle visite créée et enregistrée en session', [
                        'visit_id' => $visit->id,
                        'session_id' => session()->getId()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la création d\'une nouvelle visite', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            }

            return $visit;
        } catch (\Exception $e) {
            Log::error('Erreur lors du tracking de la visite', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // En cas d'erreur, tenter de créer une visite minimale
            try {
                $minimalVisit = Visit::create([
                    'ip' => $this->request->ip() ?: '0.0.0.0',
                    'landing_page' => $this->request->path() ?: '/',
                    'browser' => 'Inconnu',
                    'device' => 'Inconnu'
                ]);
                Log::info('Visite minimale créée suite à une erreur', [
                    'visit_id' => $minimalVisit->id
                ]);
                session()->put('visit_id', $minimalVisit->id);
                return $minimalVisit;
            } catch (\Exception $e2) {
                Log::error('Impossible de créer une visite minimale', [
                    'error' => $e2->getMessage()
                ]);
                return null;
            }
        }
    }

    /**
     * Associe un lead à la visite courante.
     *
     * @param Lead $lead
     * @return bool
     */
    public function assignVisitToLead(Lead $lead): bool
    {
        try {
            $visitId = session()->get('visit_id');

            Log::info('Tentative d\'association de visite à un lead', [
                'lead_id' => $lead->id,
                'session_visit_id' => $visitId,
                'session_id' => session()->getId()
            ]);

            if (!$visitId) {
                Log::warning('Aucun ID de visite en session lors de l\'association au lead', [
                    'lead_id' => $lead->id,
                    'session_data' => collect(session()->all())->keys()->toArray()
                ]);
                return false;
            }

            $visit = Visit::find($visitId);

            if (!$visit) {
                Log::warning('Visite introuvable lors de l\'association au lead', [
                    'visit_id' => $visitId,
                    'lead_id' => $lead->id
                ]);
                return false;
            }

            // Vérifier si la visite a déjà un lead
            if ($visit->lead_id) {
                Log::info('La visite est déjà associée à un lead', [
                    'visit_id' => $visit->id,
                    'existing_lead_id' => $visit->lead_id,
                    'new_lead_id' => $lead->id
                ]);
                // Mise à jour quand même pour s'assurer que c'est le bon lead
                $visit->lead_id = $lead->id;
                $visit->save();
            } else {
                Log::debug('Association de la visite au lead', [
                    'visit_id' => $visit->id,
                    'lead_id' => $lead->id
                ]);
                $visit->lead_id = $lead->id;
                $visit->save();
            }

            // Mettre à jour les informations UTM du lead
            $this->updateLeadUtmData($lead, $visit);

            Log::info('Visite associée au lead avec succès', [
                'visit_id' => $visit->id,
                'lead_id' => $lead->id
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'association de la visite au lead', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    /**
     * Crée une nouvelle visite avec les données de la requête.
     *
     * @return Visit
     */
    protected function createNewVisit(): Visit
    {
        $url = $this->request->fullUrl();
        $parsedUrl = parse_url($url);
        $domain = $parsedUrl['host'] ?? '';
        $page = ($parsedUrl['path'] ?? '') . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');

        // Extraire les paramètres pour rechercher les UTM
        $params = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $params);
        }

        // Récupérer le référent
        $referrer = $this->request->header('referer');
        $referrerParsed = $referrer ? parse_url($referrer) : [];
        $referrerDomain = $referrerParsed['host'] ?? '';

        // Données de l'agent utilisateur
        try {
            $browser = $this->agent->browser() ?: 'Inconnu';
            $browserVersion = $this->agent->version($browser) ?: 'Inconnu';
            $platform = $this->agent->platform() ?: 'Inconnu';
            $device = $this->getDeviceType();
        } catch (\Exception $e) {
            Log::warning('Erreur lors de la détection du navigateur', [
                'error' => $e->getMessage()
            ]);
            $browser = 'Erreur';
            $browserVersion = 'Erreur';
            $platform = 'Erreur';
            $device = 'Erreur';
        }

        // UTM parameters
        $utmSource = $params['utm_source'] ?? null;
        $utmCampaign = $params['utm_campaign'] ?? null;
        $utmMedium = $params['utm_medium'] ?? null;
        $utmTerm = $params['utm_term'] ?? null;
        $utmContent = $params['utm_content'] ?? null;

        // Identifiant de référence
        $referral = $params['ref'] ?? null;

        // Log avant création
        Log::debug('Préparation des données pour nouvelle visite', [
            'ip' => $this->request->ip(),
            'page' => $page,
            'domain' => $domain,
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
            'browser' => $browser,
            'device' => $device
        ]);

        // Création de la visite
        $visit = Visit::create([
            'ip' => $this->request->ip() ?: '0.0.0.0',
            'landing_domain' => $domain ?: 'unknown',
            'landing_page' => $page ?: '/',
            'landing_params' => json_encode($params),
            'referrer_domain' => $referrerDomain,
            'referrer' => $referrer,
            'referrer_keywords' => null, // À implémenter si nécessaire
            'browser' => $browser,
            'browser_version' => $browserVersion,
            'os' => $platform,
            'device' => $device,
            'utm_source' => $utmSource,
            'utm_campaign' => $utmCampaign,
            'utm_medium' => $utmMedium,
            'utm_term' => $utmTerm,
            'utm_content' => $utmContent,
            'referral' => $referral,
        ]);

        Log::debug('Nouvelle visite créée', [
            'visit_id' => $visit->id,
            'ip' => $visit->ip,
            'page' => $visit->landing_page
        ]);

        return $visit;
    }

    /**
     * Détermine le type d'appareil.
     *
     * @return string
     */
    protected function getDeviceType(): string
    {
        try {
            if ($this->agent->isDesktop()) {
                return 'desktop';
            } elseif ($this->agent->isTablet()) {
                return 'tablet';
            } elseif ($this->agent->isPhone()) {
                return 'mobile';
            } elseif ($this->agent->isRobot()) {
                return 'robot';
            } else {
                return 'other';
            }
        } catch (\Exception $e) {
            Log::warning('Erreur lors de la détection du type d\'appareil', [
                'error' => $e->getMessage()
            ]);
            return 'unknown';
        }
    }

    /**
     * Met à jour les informations UTM du lead.
     *
     * @param Lead $lead
     * @param Visit $visit
     * @return void
     */
    protected function updateLeadUtmData(Lead $lead, Visit $visit): void
    {
        $updated = false;

        if (!$lead->utm_source && $visit->utm_source) {
            $lead->utm_source = $visit->utm_source;
            $updated = true;
        }

        if (!$lead->utm_medium && $visit->utm_medium) {
            $lead->utm_medium = $visit->utm_medium;
            $updated = true;
        }

        if (!$lead->utm_campaign && $visit->utm_campaign) {
            $lead->utm_campaign = $visit->utm_campaign;
            $updated = true;
        }

        // Sauvegarde si des modifications ont été effectuées
        if ($updated) {
            try {
                $lead->save();
                Log::debug('Données UTM du lead mises à jour', [
                    'lead_id' => $lead->id,
                    'utm_source' => $lead->utm_source,
                    'utm_medium' => $lead->utm_medium,
                    'utm_campaign' => $lead->utm_campaign
                ]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de la mise à jour des données UTM du lead', [
                    'lead_id' => $lead->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
