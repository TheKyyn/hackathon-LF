<?php

namespace App\Http\Middleware;

use App\Services\TrackingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class TrackVisits
{
    protected $trackingService;

    /**
     * Constructeur avec injection de dépendances.
     */
    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ignorer les requêtes AJAX, les assets et les robots
        if (!$this->shouldTrack($request)) {
            Log::debug('Requête non trackée (filtrée)', [
                'url' => $request->fullUrl(),
                'ajax' => $request->ajax(),
                'path' => $request->path()
            ]);
            return $next($request);
        }

        // Tracker la visite avec plus de détails
        try {
            Log::info('🔍 DÉBUT TRACKING VISITE', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'referer' => $request->header('referer'),
                'session_id' => session()->getId(),
                'utm_params' => [
                    'source' => $request->input('utm_source'),
                    'medium' => $request->input('utm_medium'),
                    'campaign' => $request->input('utm_campaign')
                ]
            ]);

            $visit = $this->trackingService->trackVisit();

            if ($visit && $visit->id) {
                Log::info('✅ VISITE ENREGISTRÉE AVEC SUCCÈS', [
                    'visit_id' => $visit->id,
                    'session_id' => session()->getId(),
                    'ip' => $visit->ip,
                    'page' => $visit->landing_page,
                    'browser' => $visit->browser,
                    'utm_source' => $visit->utm_source,
                    'utm_medium' => $visit->utm_medium,
                    'utm_campaign' => $visit->utm_campaign
                ]);
            } else {
                Log::warning('⚠️ VISITE ENREGISTRÉE MAIS SANS ID VALIDE', [
                    'visit' => $visit ? get_object_vars($visit) : 'null'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('❌ ERREUR TRACKING VISITE', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'session_id' => session()->getId()
            ]);
        }

        // Continuer la requête
        return $next($request);
    }

    /**
     * Détermine si la requête doit être trackée.
     *
     * @param Request $request
     * @return bool
     */
    protected function shouldTrack(Request $request): bool
    {
        // Ignorer les requêtes AJAX
        if ($request->ajax()) {
            return false;
        }

        // Ignorer les assets (CSS, JS, images, etc.)
        $path = $request->path();
        if (preg_match('/(\.css|\.js|\.jpg|\.jpeg|\.png|\.gif|\.ico|\.svg|\.woff|\.woff2|\.ttf|\.eot)$/i', $path)) {
            return false;
        }

        // Ignorer certains chemins d'API ou d'administration
        $excludedPaths = ['api', 'api/*', 'nova', 'nova/*', 'telescope', 'telescope/*', '_debugbar/*'];
        foreach ($excludedPaths as $excludedPath) {
            if ($request->is($excludedPath)) {
                return false;
            }
        }

        return true;
    }
}
