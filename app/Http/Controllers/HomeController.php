<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec le formulaire multi-étapes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }
}
