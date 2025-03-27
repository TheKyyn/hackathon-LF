<?php

namespace App\Services;

use App\Models\Visit;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class VisitTrackerService
{
    /**
     * Clé du cookie pour suivre les visites.
     */
    const COOKIE_NAME = 'lead_factory_visit';

    /**
     * Durée de vie du cookie en minutes (30 jours).
     */
    const COOKIE_LIFETIME = 43200;

    /**
     * Enregistre une nouvelle visite à partir de la requête.
     *
     * @param Request $request
     * @return Visit
     */
    public function trackVisit(Request $request): Visit
    {
        try {
            // Obtenir le token du cookie
            $cookieToken = $this->getOrCreateCookieToken($request);

            // Détection du navigateur et appareil
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());

            // Créer l'enregistrement avec toutes les données disponibles
            $visit = Visit::create([
                'cookie_token' => $cookieToken,
                'landing_page' => $request->fullUrl(),
                'referrer_url' => $request->header('referer'),
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'utm_term' => $request->query('utm_term'),
                'utm_content' => $request->query('utm_content'),
                'device_type' => $this->getDeviceType($agent),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'os' => $agent->platform(),
                'ip_address' => $request->ip(), // Assurez-vous que cette ligne fonctionne
            ]);

            Log::info('Visite enregistrée', [
                'id' => $visit->id,
                'ip' => $visit->ip_address,
                'page' => $visit->landing_page
            ]);

            return $visit;
        } catch (\Exception $e) {
            Log::error('Erreur lors du tracking de la visite', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Créer une visite minimale en cas d'erreur
            return Visit::create([
                'ip_address' => $request->ip(),
                'landing_page' => $request->fullUrl()
            ]);
        }
    }

    /**
     * Associe une visite à un lead.
     *
     * @param Lead $lead
     * @param Request $request
     * @return void
     */
    public function associateVisitToLead(Lead $lead, Request $request): void
    {
        try {
            $cookieToken = $request->cookie(self::COOKIE_NAME);

            if (!$cookieToken) {
                // Si pas de cookie, essayer avec l'adresse IP
                $visit = Visit::where('ip_address', $request->ip())
                             ->where('is_converted', false)
                             ->orderBy('created_at', 'desc')
                             ->first();
            } else {
                // Recherche par cookie
                $visit = Visit::where('cookie_token', $cookieToken)
                             ->where('is_converted', false)
                             ->orderBy('created_at', 'desc')
                             ->first();
            }

            if ($visit) {
                $visit->convertToLead($lead);
                Log::info('Visite convertie en lead', [
                    'visit_id' => $visit->id,
                    'lead_id' => $lead->id
                ]);

                // Mise à jour des UTM sur le lead
                $this->updateLeadUtm($lead, $visit);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'association visite-lead', [
                'message' => $e->getMessage(),
                'lead_id' => $lead->id
            ]);
        }
    }

    private function updateLeadUtm(Lead $lead, Visit $visit): void
    {
        $utmFields = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        $updated = false;

        foreach ($utmFields as $field) {
            if (empty($lead->$field) && !empty($visit->$field)) {
                $lead->$field = $visit->$field;
                $updated = true;
            }
        }

        if ($updated) {
            $lead->save();
        }
    }

    /**
     * Obtient ou crée un token de cookie pour suivre les visites.
     *
     * @param Request $request
     * @return string
     */
    private function getOrCreateCookieToken(Request $request): string
    {
        $cookieToken = $request->cookie(self::COOKIE_NAME);

        if (!$cookieToken) {
            $cookieToken = Str::uuid()->toString();
            Cookie::queue(self::COOKIE_NAME, $cookieToken, self::COOKIE_LIFETIME);
        }

        return $cookieToken;
    }

    /**
     * Détermine le type d'appareil à partir de l'agent.
     *
     * @param Agent $agent
     * @return string
     */
    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isPhone()) {
            return 'phone';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } elseif ($agent->isDesktop()) {
            return 'desktop';
        } else {
            return 'unknown';
        }
    }
}
