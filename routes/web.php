<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendlyController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil (landing page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Formulaire multi-étapes
Route::get('/formulaire', [HomeController::class, 'form'])->name('form');

// Routes Calendly
Route::get('/calendly', [CalendlyController::class, 'show'])->name('calendly');
Route::post('/calendly/webhook', [CalendlyController::class, 'webhook'])->name('calendly.webhook');
Route::get('/confirmation', [CalendlyController::class, 'confirmation'])->name('confirmation');

// Routes pour l'administration des leads (normalement protégées par auth middleware mais désactivé pour le hackathon)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
});

// Routes pour les landing pages
Route::get('/landing/{slug}', [LandingPageController::class, 'show'])->name('landing.show');
