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
        // On récupère ou génère un token unique pour la visite
        $cookieToken = $this->getOrCreateCookieToken($request);

        // Détection du navigateur et de l'appareil
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        // Création de la visite
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
            'ip_address' => $request->ip(),
        ]);

        Log::info('Nouvelle visite enregistrée', ['visit_id' => $visit->id, 'cookie' => $cookieToken]);

        return $visit;
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
        $cookieToken = $request->cookie(self::COOKIE_NAME);

        if (!$cookieToken) {
            Log::warning('Tentative d\'association sans cookie de visite', ['lead_id' => $lead->id]);
            return;
        }

        // Recherche de la dernière visite avec ce cookie
        $visit = Visit::where('cookie_token', $cookieToken)
            ->where('is_converted', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($visit) {
            $visit->convertToLead($lead);
            Log::info('Visite convertie en lead', ['visit_id' => $visit->id, 'lead_id' => $lead->id]);

            // Copie des UTM sur le lead pour rétrocompatibilité
            if (!$lead->utm_source && $visit->utm_source) {
                $lead->utm_source = $visit->utm_source;
            }

            if (!$lead->utm_medium && $visit->utm_medium) {
                $lead->utm_medium = $visit->utm_medium;
            }

            if (!$lead->utm_campaign && $visit->utm_campaign) {
                $lead->utm_campaign = $visit->utm_campaign;
            }

            $lead->save();
        } else {
            Log::warning('Aucune visite non convertie trouvée pour ce cookie', [
                'cookie' => $cookieToken,
                'lead_id' => $lead->id
            ]);
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
