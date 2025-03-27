<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\CalendlyController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LandingPageController;

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

// Routes principales
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
Route::get('/landing', [LandingPageController::class, 'default'])->name('landing.default');

// Routes de test
Route::get('/test-calendly', function () {
    return view('calendly-test');
})->name('test.calendly');

Route::get('/test-email-form', function () {
    return view('test-email');
})->name('test.email.form');

Route::get('/test-calendly-webhook', [TestController::class, 'testCalendlyWebhook'])->name('test.webhook');
Route::get('/test-email', [TestController::class, 'testEmailSending'])->name('test.email');
Route::get('/test-email-config', [TestController::class, 'showEmailConfig'])->name('test.email.config');
Route::get('/test-native-mail', [TestController::class, 'testNativeMail'])->name('test.native.mail');
