<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Affiche une landing page spécifique.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $landing = LandingPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('landing-page', compact('landing'));
    }

    /**
     * Affiche la landing page par défaut (première active).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function default()
    {
        $landing = LandingPage::where('is_active', true)->first();

        if (!$landing) {
            return redirect()->route('home')->with('error', 'Aucune landing page disponible.');
        }

        return view('landing-page', compact('landing'));
    }
}
