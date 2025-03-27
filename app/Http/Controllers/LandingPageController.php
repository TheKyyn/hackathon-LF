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
     * @return \Illuminate\View\View
     */
    public function default()
    {
        $landing = LandingPage::getDefault();
        return view('landing-page', compact('landing'));
    }
}
