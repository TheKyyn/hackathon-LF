<?php

namespace App\Nova\Metrics;

use App\Models\Visit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class VisitToLeadConversionMetric extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $totalVisits = Visit::count();

        if ($totalVisits === 0) {
            return $this->result(0)->suffix('%');
        }

        $convertedVisits = Visit::where('is_converted', true)->count();
        $conversionRate = ($convertedVisits / $totalVisits) * 100;

        return $this->result(round($conversionRate, 2))->suffix('%');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'ALL' => 'Tout le temps',
            30 => '30 derniers jours',
            60 => '60 derniers jours',
            90 => '90 derniers jours',
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'visit-to-lead-conversion-metric';
    }

    /**
     * Get the displayable name of the metric
     *
     * @return string
     */
    public function name()
    {
        return 'Taux de conversion';
    }
}
