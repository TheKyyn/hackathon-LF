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
            // Champs de contenu principaux
            $table->string('subtitle')->nullable()->after('title');
            $table->text('advantages_title')->nullable()->after('content');
            $table->text('advantages_list')->nullable()->after('advantages_title');
            $table->string('cta_text')->default('Commencer maintenant')->after('advantages_list');
            $table->string('cta_color')->default('#4CAF50')->after('cta_text');

            // Champs de style
            $table->string('primary_color')->default('#4CAF50')->after('cta_color');
            $table->string('secondary_color')->default('#2196F3')->after('primary_color');
            $table->string('background_image')->nullable()->after('secondary_color');
            $table->string('logo')->nullable()->after('background_image');

            // Champs SEO supplémentaires
            $table->string('og_title')->nullable()->after('meta_keywords');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'subtitle', 'advantages_title', 'advantages_list', 'cta_text', 'cta_color',
                'primary_color', 'secondary_color', 'background_image', 'logo',
                'og_title', 'og_description', 'og_image'
            ]);
        });
    }
};
