<?php

namespace App\Nova\Metrics;

use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;
use Laravel\Nova\Nova;

class TotalLeads extends Value
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->count($request, \App\Models\Lead::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array<string, int>
     */
    public function ranges(): array
    {
        return [
            'ALL' => __('Tous'),
            'TODAY' => __('Aujourd\'hui'),
            'WEEK' => __('Cette semaine'),
            'MTD' => __('Ce mois-ci'),
            'QTD' => __('Ce trimestre'),
            'YTD' => __('Cette année'),
        ];
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name(): string
    {
        return __('Total des leads');
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): DateTimeInterface|null
    {
        // return now()->addMinutes(5);

        return null;
    }
}
