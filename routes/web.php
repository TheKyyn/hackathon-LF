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
Route::get('/landing/{slug}', function ($slug) {
    $landing = \App\Models\LandingPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
    // Inclure les métadonnées
    $meta = [
        'title' => $landing->getValueOrDefault('title', 'Landing Page'),
        'description' => $landing->getValueOrDefault('meta_description', ''),
        'keywords' => $landing->getValueOrDefault('meta_keywords', ''),
        'og_title' => $landing->getValueOrDefault('og_title', $landing->getValueOrDefault('title', 'Landing Page')),
        'og_description' => $landing->getValueOrDefault('og_description', ''),
        'og_image' => $landing->isCustomized('og_image') ? asset('storage/' . $landing->og_image) : '',
    ];
    return view('landing', ['landing' => $landing, 'meta' => $meta]);
})->name('landing.show');

// Route pour la landing page par défaut
Route::get('/landing', function () {
    $landing = \App\Models\LandingPage::getDefault();
    // Inclure les métadonnées
    $meta = [
        'title' => $landing->getValueOrDefault('title', 'Landing Page'),
        'description' => $landing->getValueOrDefault('meta_description', ''),
        'keywords' => $landing->getValueOrDefault('meta_keywords', ''),
        'og_title' => $landing->getValueOrDefault('og_title', $landing->getValueOrDefault('title', 'Landing Page')),
        'og_description' => $landing->getValueOrDefault('og_description', ''),
        'og_image' => $landing->isCustomized('og_image') ? asset('storage/' . $landing->og_image) : '',
    ];
    return view('landing', ['landing' => $landing, 'meta' => $meta]);
})->name('landing.default');

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

// Routes de test pour les champs virtuels dans LandingPage
Route::get('/test-landing-virtual-fields', function() {
    // Tester un champ virtuel
    $result1 = \App\Models\LandingPage::testVirtualField('guarantee3_title', 'Test Garantie 3');
    $result2 = \App\Models\LandingPage::testVirtualField('primary_color', '#FF0000');

    // Tester la création complète
    $result3 = \App\Models\LandingPage::testCreateWithVirtualFields();

    return [
        'virtual_field_test' => $result1,
        'regular_field_test' => $result2,
        'create_test' => $result3,
    ];
})->middleware(['auth'])->name('test-landing-virtual-fields');
