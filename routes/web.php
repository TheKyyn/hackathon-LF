<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendlyController;
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

// Page d'accueil avec le formulaire multi-étapes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes Calendly
Route::get('/calendly', [CalendlyController::class, 'show'])->name('calendly');
Route::post('/calendly/webhook', [CalendlyController::class, 'webhook'])->name('calendly.webhook');
Route::get('/confirmation', [CalendlyController::class, 'confirmation'])->name('confirmation');

// Route pour l'administration des leads
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/leads', function () {
        return view('admin.leads.index');
    })->name('admin.leads.index');
});
