<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;
use App\Nova\Metrics\VisitsTrendMetric;
use App\Nova\Metrics\VisitsBySourceMetric;
use App\Nova\Metrics\VisitToLeadConversionMetric;

class VisitsDashboard extends Dashboard
{
    public function name()
    {
        return 'Analytique des visites';
    }

    public function cards()
    {
        return [
            new VisitsTrendMetric(),
            new VisitsBySourceMetric(),
            new VisitToLeadConversionMetric(),
        ];
    }
}