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
            // Champs pour l'en-tête
            $table->string('publi_text')->nullable();
            $table->string('main_image')->nullable();
            $table->string('annonce_text')->nullable();
            $table->string('annonce_bg_color')->nullable();
            $table->string('author_name')->nullable();
            $table->string('published_time')->nullable();
            $table->string('author_photo')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('banner_image')->nullable();

            // Champs pour la section d'éligibilité
            $table->text('eligibility_intro')->nullable();
            $table->string('eligibility_point1')->nullable();
            $table->string('eligibility_point2')->nullable();
            $table->string('eligibility_point3')->nullable();
            $table->string('eligibility_point4')->nullable();
            $table->string('eligibility_btn_text')->nullable();
            $table->string('eligibility_btn_url')->nullable();
            $table->string('eligibility_bg_color')->nullable();
            $table->string('eligibility_btn_color')->nullable();

            // Champs pour la section des subventions
            $table->text('subsidies_title')->nullable();
            $table->string('subsidies_image1')->nullable();
            $table->string('subsidies_image2')->nullable();
            $table->text('subsidies_paragraph1')->nullable();
            $table->text('subsidies_paragraph2')->nullable();

            // Champs pour la section des coûts
            $table->string('costs_title')->nullable();
            $table->string('costs_option1')->nullable();
            $table->string('costs_option2')->nullable();
            $table->string('costs_option3')->nullable();
            $table->string('costs_option4')->nullable();
            $table->string('costs_option1_url')->nullable();
            $table->string('costs_option2_url')->nullable();
            $table->string('costs_option3_url')->nullable();
            $table->string('costs_option4_url')->nullable();

            // Champs pour la section d'opportunité
            $table->string('opportunity_title')->nullable();
            $table->text('opportunity_paragraph1')->nullable();
            $table->text('opportunity_paragraph2')->nullable();
            $table->text('opportunity_warning')->nullable();
            $table->string('opportunity_btn_text')->nullable();
            $table->string('opportunity_btn_url')->nullable();
            $table->string('opportunity_bg_color')->nullable();
            $table->string('opportunity_btn_color')->nullable();

            // Champs pour les autres sections
            // ... Ajouter d'autres champs au besoin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            // Suppression des champs pour l'en-tête
            $table->dropColumn([
                'publi_text', 'main_image', 'annonce_text', 'annonce_bg_color',
                'author_name', 'published_time', 'author_photo', 'cta_url', 'banner_image',

                // Éligibilité
                'eligibility_intro', 'eligibility_point1', 'eligibility_point2',
                'eligibility_point3', 'eligibility_point4', 'eligibility_btn_text',
                'eligibility_btn_url', 'eligibility_bg_color', 'eligibility_btn_color',

                // Subventions
                'subsidies_title', 'subsidies_image1', 'subsidies_image2',
                'subsidies_paragraph1', 'subsidies_paragraph2',

                // Coûts
                'costs_title', 'costs_option1', 'costs_option2', 'costs_option3',
                'costs_option4', 'costs_option1_url', 'costs_option2_url',
                'costs_option3_url', 'costs_option4_url',

                // Opportunité
                'opportunity_title', 'opportunity_paragraph1', 'opportunity_paragraph2',
                'opportunity_warning', 'opportunity_btn_text', 'opportunity_btn_url',
                'opportunity_bg_color', 'opportunity_btn_color'
            ]);
        });
    }
};
