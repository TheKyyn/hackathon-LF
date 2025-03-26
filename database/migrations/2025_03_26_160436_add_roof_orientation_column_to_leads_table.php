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
            // Ajouter la colonne roof_orientation si elle n'existe pas
            if (!Schema::hasColumn('leads', 'roof_orientation')) {
                $table->string('roof_orientation')->nullable()->after('roof_material');
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
            if (Schema::hasColumn('leads', 'roof_orientation')) {
                $table->dropColumn('roof_orientation');
            }
        });
    }
};
