<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\VisitTrackerService;

class TrackVisitMiddleware
{
    /**
     * @var VisitTrackerService
     */
    protected $visitTracker;

    /**
     * Constructeur.
     *
     * @param VisitTrackerService $visitTracker
     */
    public function __construct(VisitTrackerService $visitTracker)
    {
        $this->visitTracker = $visitTracker;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ne pas tracker les requêtes AJAX, les assets ou les routes administratives
        if ($request->ajax() ||
            $this->isAssetRequest($request) ||
            $this->isNovaRequest($request) ||
            $this->isApiRequest($request)) {
            return $next($request);
        }

        // Tracker la visite
        $visit = $this->visitTracker->trackVisit($request);

        // Stocker la visite dans la requête pour une utilisation ultérieure
        $request->attributes->set('tracked_visit', $visit);

        return $next($request);
    }

    /**
     * Détermine si la requête concerne un fichier asset.
     *
     * @param Request $request
     * @return bool
     */
    private function isAssetRequest(Request $request): bool
    {
        $path = $request->path();
        $assetExtensions = ['js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'];

        foreach ($assetExtensions as $ext) {
            if (str_ends_with($path, '.' . $ext)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Détermine si la requête concerne Nova.
     *
     * @param Request $request
     * @return bool
     */
    private function isNovaRequest(Request $request): bool
    {
        return str_starts_with($request->path(), 'nova') ||
               str_starts_with($request->path(), 'nova-api');
    }

    /**
     * Détermine si la requête concerne l'API.
     *
     * @param Request $request
     * @return bool
     */
    private function isApiRequest(Request $request): bool
    {
        return str_starts_with($request->path(), 'api');
    }
}
