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
            // Vérifier si les colonnes n'existent pas avant de les ajouter
            if (!Schema::hasColumn('leads', 'call_status')) {
                $table->string('call_status')->nullable()->default('à appeler'); // à appeler, appelé, rappeler
            }

            // Le champ sale_status existe déjà, ne pas l'ajouter

            if (!Schema::hasColumn('leads', 'comment')) {
                $table->text('comment')->nullable(); // commentaire libre
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'call_status')) {
                $table->dropColumn('call_status');
            }

            if (Schema::hasColumn('leads', 'comment')) {
                $table->dropColumn('comment');
            }
        });
    }
};
