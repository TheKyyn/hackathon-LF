<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Affiche la landing page spécifiée.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $landing = LandingPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('landing-pages.show', compact('landing'));
    }
}
