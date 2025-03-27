<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer quelques leads de test
        Lead::create([
            // Informations personnelles
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'phone' => '0601020304',
            'birth_date' => '1965-05-15',

            // Localisation
            'address' => '123 Rue de la République',
            'postal_code' => '75001',
            'city' => 'Paris',
            'location_type' => 'code_postal',

            // Informations sur le logement
            'energy_bill' => 'more_300',
            'is_owner' => true,
            'property_type' => 'maison',
            'property_size' => '101_150',
            'household_status' => 'retraite',
            'heating_type' => 'fioul',
            'roof_insulated' => true,
            'roof_material' => 'tuile',

            // Informations sur le projet
            'installation_type' => 'photovoltaique',
            'panel_size' => '20m',
            'accept_aid' => true,
            'household_count' => '2',
            'annual_income' => '20k_40k',

            // Autres informations
            'optin' => true,
            'ip_address' => '127.0.0.1',
            'status' => 'new',
        ]);

        Lead::create([
            // Informations personnelles
            'first_name' => 'Marie',
            'last_name' => 'Martin',
            'email' => 'marie.martin@example.com',
            'phone' => '0701020304',
            'birth_date' => '1975-09-23',

            // Localisation
            'address' => '456 Avenue des Champs-Élysées',
            'postal_code' => '75008',
            'city' => 'Paris',
            'location_type' => 'code_postal',

            // Informations sur le logement
            'energy_bill' => '200_300',
            'is_owner' => true,
            'property_type' => 'studio',
            'property_size' => '51_100',
            'household_status' => 'cdi',
            'heating_type' => 'electrique',
            'roof_insulated' => false,
            'roof_material' => 'ardoise',

            // Informations sur le projet
            'installation_type' => 'chauffe_eau',
            'pac_type' => 'air_eau',
            'accept_aid' => true,
            'household_count' => '1',
            'annual_income' => 'less_20k',

            // Autres informations
            'optin' => false,
            'ip_address' => '127.0.0.1',
            'status' => 'new',
        ]);

        Lead::create([
            // Informations personnelles
            'first_name' => 'Pierre',
            'last_name' => 'Durand',
            'email' => 'pierre.durand@example.com',
            'phone' => '0609080706',
            'birth_date' => '1980-01-10',

            // Localisation
            'address' => '789 Boulevard Saint-Michel',
            'postal_code' => '75005',
            'city' => 'Paris',
            'location_type' => 'code_postal',

            // Informations sur le logement
            'energy_bill' => 'more_300',
            'is_owner' => true,
            'property_type' => 'maison',
            'property_size' => 'more_200',
            'household_status' => 'cdi',
            'heating_type' => 'gaz',
            'roof_insulated' => true,
            'roof_material' => 'tuile',

            // Informations sur le projet
            'installation_type' => 'solaire',
            'panel_size' => '30m',
            'accept_aid' => true,
            'household_count' => '4_plus',
            'annual_income' => 'more_40k',

            // Rendez-vous et suivi
            'appointment_date' => now()->addDays(3),
            'appointment_id' => 'calendly-123456',

            // Autres informations
            'optin' => true,
            'ip_address' => '127.0.0.1',
            'status' => 'contacted',
            'sale_status' => 'to_sell',
        ]);
    }
}
