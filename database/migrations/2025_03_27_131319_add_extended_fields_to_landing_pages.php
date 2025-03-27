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
            // Champs d'en-tête
            $table->string('header_title')->nullable()->after('logo');
            $table->string('header_subtitle')->nullable()->after('header_title');
            $table->string('header_cta_text')->default('Obtenez un devis')->after('header_subtitle');
            $table->string('header_cta_url')->nullable()->after('header_cta_text');

            // Champs de contenu supplémentaires
            $table->string('section1_title')->nullable()->after('content');
            $table->longText('section1_content')->nullable()->after('section1_title');
            $table->string('section2_title')->nullable()->after('section1_content');
            $table->longText('section2_content')->nullable()->after('section2_title');
            $table->string('section3_title')->nullable()->after('section2_content');
            $table->longText('section3_content')->nullable()->after('section3_title');

            // Témoignages
            $table->json('testimonials')->nullable()->after('section3_content');

            // FAQ
            $table->string('faq_title')->nullable()->after('testimonials');
            $table->longText('faq_content')->nullable()->after('faq_title');

            // Pied de page
            $table->string('footer_text')->default('© 2025 Lead Factory - Tous droits réservés')->after('faq_content');
            $table->json('footer_links')->nullable()->after('footer_text');

            // Personnalisation avancée
            $table->longText('custom_css')->nullable()->after('footer_links');
            $table->longText('custom_js')->nullable()->after('custom_css');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'header_title', 'header_subtitle', 'header_cta_text', 'header_cta_url',
                'section1_title', 'section1_content', 'section2_title', 'section2_content',
                'section3_title', 'section3_content', 'testimonials', 'faq_title', 'faq_content',
                'footer_text', 'footer_links', 'custom_css', 'custom_js'
            ]);
        });
    }
};
