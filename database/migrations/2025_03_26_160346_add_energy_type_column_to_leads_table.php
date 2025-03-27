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
        Schema::table('leads', function (Blueprint $table) {
            // Ajouter la colonne energy_type s'elle n'existe pas
            if (!Schema::hasColumn('leads', 'energy_type')) {
                $table->string('energy_type')->nullable()->after('energy_bill');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Supprimer la colonne si elle existe
            if (Schema::hasColumn('leads', 'energy_type')) {
                $table->dropColumn('energy_type');
            }
        });
    }
};
