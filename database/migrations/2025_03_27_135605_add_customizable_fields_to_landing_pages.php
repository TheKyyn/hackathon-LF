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
        Schema::table('landing_pages', function (Blueprint $table) {
            // Vérifier si le champ custom_fields existe déjà
            if (!Schema::hasColumn('landing_pages', 'custom_fields')) {
                // Champ custom_fields pour stocker toutes les valeurs personnalisées
                $table->json('custom_fields')->nullable();
            }

            // Vérifier si le champ blue_color existe déjà
            if (!Schema::hasColumn('landing_pages', 'blue_color')) {
                // Couleurs de base
                $table->string('blue_color')->nullable()->default('#013565');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            // Supprimer les colonnes seulement si elles existent
            $columns = ['custom_fields', 'blue_color'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('landing_pages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
