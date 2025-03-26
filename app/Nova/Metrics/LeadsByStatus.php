<?php

namespace App\Nova\Metrics;

use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class LeadsByStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, \App\Models\Lead::class, 'sale_status')
            ->label(function($value) {
                return match($value) {
                    'à vendre' => 'À vendre',
                    'vendu' => 'Vendu',
                    'annulé' => 'Annulé',
                    default => $value,
                };
            })
            ->colors([
                'à vendre' => '#F9A825', // Orange
                'vendu' => '#4CAF50',    // Vert
                'annulé' => '#F44336',   // Rouge
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
        return 'leads-by-status';
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name(): string
    {
        return __('Leads par statut de vente');
    }
}
