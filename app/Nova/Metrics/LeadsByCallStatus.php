<?php

namespace App\Nova\Metrics;

use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class LeadsByCallStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, \App\Models\Lead::class, 'call_status')
            ->label(function($value) {
                return match($value) {
                    'à appeler' => 'À appeler',
                    'appelé' => 'Appelé',
                    'rappeler' => 'Rappeler',
                    default => $value,
                };
            })
            ->colors([
                'à appeler' => '#F9A825', // Orange
                'appelé' => '#4CAF50',    // Vert
                'rappeler' => '#2196F3',   // Bleu
            ]);
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): DateTimeInterface|null
    {
        // return now()->addMinutes(5);

        return null;
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'leads-by-call-status';
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name(): string
    {
        return __('Leads par statut d\'appel');
    }
}
