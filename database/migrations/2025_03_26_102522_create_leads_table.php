<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            // Informations personnelles
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();

            // Localisation
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('department')->nullable();
            $table->string('location_type')->nullable(); // code_postal ou departement

            // Informations sur le logement
            $table->string('energy_bill')->nullable(); // Montant facture d'énergie
            $table->boolean('is_owner')->nullable(); // propriétaire ou locataire
            $table->string('property_type')->nullable(); // maison, studio, t2, t3+, autre
            $table->string('property_size')->nullable(); // surface habitable
            $table->string('household_status')->nullable(); // CDI, CDD, chômage, retraité, autre
            $table->string('heating_type')->nullable(); // Type de chauffage actuel
            $table->boolean('roof_insulated')->nullable(); // Toiture isolée ou non
            $table->string('roof_material')->nullable(); // Matériau de la toiture

            // Informations sur le projet
            $table->string('installation_type')->nullable(); // Type d'installation souhaitée
            $table->string('panel_size')->nullable(); // Surface de panneaux
            $table->string('pac_type')->nullable(); // Type de PAC
            $table->boolean('accept_aid')->nullable(); // Accepte les aides gouvernementales
            $table->string('household_count')->nullable(); // Nombre de personnes dans le foyer
            $table->string('annual_income')->nullable(); // Revenus annuels

            // Rendez-vous et suivi
            $table->date('appointment_date')->nullable(); // date de rendez-vous Calendly
            $table->string('appointment_id')->nullable(); // identifiant de rendez-vous Calendly
            $table->boolean('optin')->default(false); // Consentement RGPD

            // Tracking et statut
            $table->string('ip_address')->nullable(); // Adresse IP
            $table->string('utm_source')->nullable(); // Source UTM pour le tracking
            $table->string('utm_medium')->nullable(); // Medium UTM pour le tracking
            $table->string('utm_campaign')->nullable(); // Campaign UTM pour le tracking
            $table->string('status')->default('new'); // Statut du lead: nouveau, contacté, qualifié, etc.
            $table->string('sale_status')->nullable(); // Statut de vente: à vendre, vendu, annulé
            $table->text('comment')->nullable(); // Commentaires sur le lead
            $table->string('airtable_id')->nullable(); // ID dans Airtable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
