<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Nova\Metrics\TotalLeads;
use App\Nova\Metrics\LeadsPerDay;
use App\Nova\Metrics\LeadsByStatus;
use App\Nova\Metrics\LeadsByCallStatus;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            new TotalLeads(),
            (new LeadsPerDay())->width('2/3'),
            (new LeadsByStatus())->width('1/2'),
            (new LeadsByCallStatus())->width('1/2'),
        ];
    }
}
