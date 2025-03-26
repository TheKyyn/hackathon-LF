<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Affiche la liste des leads.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $leads = Lead::latest()->get();

        return view('admin.leads.index', [
            'leads' => $leads
        ]);
    }

    /**
     * Affiche les détails d'un lead.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\View\View
     */
    public function show(Lead $lead)
    {
        return view('admin.leads.show', [
            'lead' => $lead
        ]);
    }

    /**
     * Affiche le formulaire d'édition d'un lead.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\View\View
     */
    public function edit(Lead $lead)
    {
        return view('admin.leads.edit', [
            'lead' => $lead
        ]);
    }

    /**
     * Met à jour un lead.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'sale_status' => 'nullable|string',
            'comment' => 'nullable|string',
        ]);

        $lead->update($validated);

        return redirect()->route('admin.leads.show', $lead)
            ->with('success', 'Lead mis à jour avec succès.');
    }
}
