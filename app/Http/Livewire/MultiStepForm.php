<?php

namespace App\Http\Livewire;

use App\Services\TrackingService;
use App\Models\Lead;
use Livewire\Component;

class MultiStepForm extends Component
{
    public function submit()
    {
        // ... existing validation and lead creation code ...

        try {
            // ... existing validation and lead creation code ...

            $lead = Lead::create($data);

            // Associer la visite au lead
            app(TrackingService::class)->assignVisitToLead($lead);

            // ... existing success handling code ...
        }
        // ... existing error handling code ...
    }
}
