<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Affiche le formulaire multi-étapes.
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return view('home');
    }
}
