<?php

namespace App\Nova;

use App\Nova\Actions\DuplicateLandingPage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Panel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\JSON;

class LandingPage extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\LandingPage>
     */
    public static $model = \App\Models\LandingPage::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'slug',
    ];

    /**
     * Les champs virtuels qui sont gérés via custom_fields.
     *
     * @var array
     */
    protected $virtualFields = [
        'guarantee3_title', 'guarantee3_text',
        'benefits_title', 'benefit1_text', 'benefit2_text', 'benefit3_text',
        'footer_logo', 'footer_image', 'mentions_text', 'mentions_url',
        'privacy_text', 'privacy_url'
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Landing Pages');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Landing Page');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            // Informations générales
            new Panel('Informations générales', [
                Text::make('Titre', 'title')
                    ->sortable()
                    ->rules('required', 'max:255'),

                Text::make('Sous-titre', 'subtitle')
                    ->hideFromIndex()
                    ->nullable(),

                Slug::make('Slug', 'slug')
                    ->from('title')
                    ->rules('required', 'max:255')
                    ->creationRules('unique:landing_pages,slug')
                    ->updateRules('unique:landing_pages,slug,{{resourceId}}'),

                Boolean::make('Actif', 'is_active')
                    ->sortable()
                    ->default(true),
            ]),

            // Couleurs et apparence
            new Panel('Couleurs et apparence', [
                Color::make('Couleur principale', 'primary_color')
                    ->default('#4CAF50')
                    ->hideFromIndex(),

                Color::make('Couleur secondaire', 'secondary_color')
                    ->default('#2196F3')
                    ->hideFromIndex(),

                Color::make('Couleur des CTA', 'cta_color')
                    ->default('#41b99f')
                    ->hideFromIndex(),

                Color::make('Couleur bleu', 'blue_color')
                    ->default('#013565')
                    ->hideFromIndex(),
            ]),

            // En-tête
            new Panel('En-tête', [
                Text::make('Texte du publi-reportage', 'publi_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte qui apparaît en haut de la page. Par défaut: "publi-reportage"'),

                Image::make('Image principale', 'main_image')
                    ->hideFromIndex()
                    ->disk('public')
                    ->nullable()
                    ->path('landing-pages')
                    ->help('Grande image en haut de la page. Formats recommandés: JPG. Recommandé: 1920x400px')
                    ->prunable(),

                Text::make('Texte annonce', 'annonce_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte de l\'annonce en haut de la page. Par défaut: "annonce importante"'),

                Color::make('Couleur de l\'annonce', 'annonce_bg_color')
                    ->default('#013565')
                    ->hideFromIndex(),

                Text::make('Nom de l\'auteur', 'author_name')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Nom de l\'auteur à afficher. Par défaut: "Arthur Lafont"'),

                Text::make('Date de publication', 'published_time')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte indiquant quand l\'article a été publié. Par défaut: "il y a 2h"'),

                Image::make('Photo de l\'auteur', 'author_photo')
                    ->hideFromIndex()
                    ->disk('public')
                    ->nullable()
                    ->path('landing-pages')
                    ->help('Photo de l\'auteur. Recommandé: 100x100px, format rond')
                    ->prunable(),

                Text::make('Titre principal', 'header_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre principal de la landing page'),

                Text::make('Sous-titre principal', 'header_subtitle')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Sous-titre qui apparaît sous le titre principal'),

                Text::make('Texte du CTA', 'cta_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte du bouton principal. Par défaut: "Vérifiez si vous êtes éligible sur le site officiel franceinfoénergie.fr"'),

                Text::make('URL du CTA', 'cta_url')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('URL du bouton principal. Par défaut: URL du formulaire'),

                Image::make('Image bannière', 'banner_image')
                    ->hideFromIndex()
                    ->disk('public')
                    ->nullable()
                    ->path('landing-pages')
                    ->help('Image sous le bouton principal. Recommandé: 1200x400px')
                    ->prunable(),
            ]),

            // Section Éligibilité
            new Panel('Section Éligibilité', [
                Text::make('Introduction éligibilité', 'eligibility_intro')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte d\'introduction de la section éligibilité'),

                Text::make('Point d\'éligibilité 1', 'eligibility_point1')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Point d\'éligibilité 2', 'eligibility_point2')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Point d\'éligibilité 3', 'eligibility_point3')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Point d\'éligibilité 4', 'eligibility_point4')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Texte du bouton d\'éligibilité', 'eligibility_btn_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte du bouton dans la section éligibilité. Par défaut: "vérifier mes droits"'),

                Text::make('URL du bouton d\'éligibilité', 'eligibility_btn_url')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('URL du bouton dans la section éligibilité. Par défaut: URL du formulaire'),

                Color::make('Couleur de la section éligibilité', 'eligibility_bg_color')
                    ->default('#41b99f')
                    ->hideFromIndex(),

                Color::make('Couleur du bouton d\'éligibilité', 'eligibility_btn_color')
                    ->default('#41b99f')
                    ->hideFromIndex(),
            ]),

            // Section Comment ça marche
            new Panel('Section Comment ça marche', [
                Text::make('Titre', 'how_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la section Comment ça marche. Par défaut: "Comment ça marche ?"'),

                Text::make('Étape 1 - Titre', 'step1_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la première étape. Par défaut: "Remplissez le formulaire"'),

                Text::make('Étape 1 - Texte', 'step1_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Description de la première étape'),

                Text::make('Étape 2 - Titre', 'step2_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la deuxième étape. Par défaut: "Échangez avec un expert"'),

                Text::make('Étape 2 - Texte', 'step2_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Description de la deuxième étape'),

                Text::make('Étape 3 - Titre', 'step3_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la troisième étape. Par défaut: "Recevez votre étude gratuite"'),

                Text::make('Étape 3 - Texte', 'step3_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Description de la troisième étape'),
            ]),

            // Section Call to Action
            new Panel('Section Call to Action', [
                Text::make('Titre CTA', 'cta_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la section CTA. Par défaut: "Profitez dès maintenant de votre étude gratuite"'),

                Text::make('Texte CTA', 'cta_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte de la section CTA'),

                Text::make('Bouton CTA', 'cta_button')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte du bouton CTA. Par défaut: "Je fais ma demande gratuitement"'),
            ]),

            // Section Formulaire
            new Panel('Section Formulaire', [
                Text::make('Titre formulaire', 'form_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la section formulaire. Par défaut: "Demandez votre étude personnalisée gratuite"'),

                Text::make('Texte formulaire', 'form_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte d\'introduction de la section formulaire'),

                Text::make('Garantie 1 - Titre', 'guarantee1_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la première garantie. Par défaut: "Service 100% gratuit"'),

                Text::make('Garantie 1 - Texte', 'guarantee1_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Description de la première garantie'),

                Text::make('Garantie 2 - Titre', 'guarantee2_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la deuxième garantie. Par défaut: "Experts certifiés"'),

                Text::make('Garantie 2 - Texte', 'guarantee2_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Description de la deuxième garantie'),

                Text::make('Garantie 3 - Titre', 'guarantee3_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la troisième garantie. Par défaut: "Installateurs agréés"'),

                Text::make('Garantie 3 - Texte', 'guarantee3_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Description de la troisième garantie'),
            ]),

            // Section Avantages
            new Panel('Section Avantages', [
                Text::make('Titre avantages', 'benefits_title')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Titre de la section avantages. Par défaut: "Pourquoi passer au solaire ?"'),

                Text::make('Avantage 1', 'benefit1_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Premier avantage de passer au solaire'),

                Text::make('Avantage 2', 'benefit2_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Deuxième avantage de passer au solaire'),

                Text::make('Avantage 3', 'benefit3_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Troisième avantage de passer au solaire'),
            ]),

            // Section Footer
            new Panel('Section Footer', [
                Image::make('Logo Footer', 'footer_logo')
                    ->hideFromIndex()
                    ->disk('public')
                    ->nullable()
                    ->path('landing-pages')
                    ->help('Logo dans le pied de page. Recommandé: format SVG ou PNG transparent')
                    ->prunable(),

                Image::make('Image Footer', 'footer_image')
                    ->hideFromIndex()
                    ->disk('public')
                    ->nullable()
                    ->path('landing-pages')
                    ->help('Image secondaire dans le pied de page')
                    ->prunable(),

                Text::make('Texte mentions', 'mentions_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte pour le lien des mentions légales. Par défaut: "Mentions légales"'),

                Text::make('URL mentions', 'mentions_url')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Lien pour les mentions légales'),

                Text::make('Texte confidentialité', 'privacy_text')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Texte pour le lien de la politique de confidentialité. Par défaut: "Politique de confidentialité"'),

                Text::make('URL confidentialité', 'privacy_url')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Lien pour la politique de confidentialité'),
            ]),

            // Contenu principal
            new Panel('Contenu principal', [
                Trix::make('Contenu principal', 'content')
                    ->hideFromIndex()
                    ->nullable()
                    ->help('Si laissé vide, un contenu par défaut sera utilisé'),
            ]),

            // SEO et Métadonnées
            new Panel('SEO et Métadonnées', [
                Text::make('Meta Description', 'meta_description')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Meta Keywords', 'meta_keywords')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('OG Title', 'og_title')
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('OG Description', 'og_description')
                    ->hideFromIndex()
                    ->nullable(),

                Image::make('OG Image', 'og_image')
                    ->hideFromIndex()
                    ->disk('public')
                    ->nullable()
                    ->path('landing-pages')
                    ->help('Image pour les réseaux sociaux (recommandé: 1200x630px, JPG/PNG)')
                    ->prunable(),
            ]),

            // CSS et JavaScript personnalisés
            new Panel('CSS et JavaScript personnalisés', [
                Code::make('CSS personnalisé', 'custom_css')
                    ->language('css')
                    ->hideFromIndex()
                    ->nullable(),

                Code::make('JavaScript personnalisé', 'custom_js')
                    ->language('javascript')
                    ->hideFromIndex()
                    ->nullable(),
            ]),

            // Champs personnalisés supplémentaires
            new Panel('Champs personnalisés supplémentaires', [
                KeyValue::make('Champs personnalisés', 'custom_fields')
                    ->hideFromIndex()
                    ->keyLabel('Nom du champ')
                    ->valueLabel('Contenu')
                    ->actionText('Ajouter un champ')
                    ->help('Utilisez cette section pour personnaliser d\'autres éléments de la landing page'),
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new DuplicateLandingPage,
        ];
    }

    /**
     * Prépare les données avant la sauvegarde.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param array $data
     * @return array
     */
    public static function beforeSave(NovaRequest $request, $data)
    {
        // Initialiser les custom_fields s'ils n'existent pas
        $customFields = json_decode($data['custom_fields'] ?? '{}', true) ?: [];

        // Récupérer l'instance du modèle
        $instance = isset($request->resourceId) ? \App\Models\LandingPage::find($request->resourceId) : new \App\Models\LandingPage();

        // Pour chaque champ virtuel, le déplacer vers custom_fields
        foreach ((new static)->virtualFields as $field) {
            if (isset($data[$field])) {
                $customFields[$field] = $data[$field];
                unset($data[$field]);
            }
        }

        // Mettre à jour custom_fields
        $data['custom_fields'] = json_encode($customFields);

        return $data;
    }

    /**
     * Fill a new model instance using the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $resource
     * @param  string  $attribute
     * @return array
     */
    /* public static function fill(NovaRequest $request, $model, $resource = null, $attribute = null)
    {
        $data = parent::fill($request, $model, $resource, $attribute);

        // Préparer les données avant la sauvegarde
        if (is_array($data)) {
            $data = static::beforeSave($request, $data);
        }

        return $data;
    } */
}
