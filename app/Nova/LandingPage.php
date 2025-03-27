<?php

namespace App\Nova;

use App\Nova\Actions\DuplicateLandingPage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

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
                ->sortable(),

            // Contenu principal
            Trix::make('Contenu', 'content')
                ->hideFromIndex(),

            Text::make('Titre des avantages', 'advantages_title')
                ->hideFromIndex()
                ->nullable(),

            Trix::make('Liste des avantages', 'advantages_list')
                ->hideFromIndex()
                ->nullable(),

            // Call-to-Action
            Text::make('Texte du CTA', 'cta_text')
                ->hideFromIndex()
                ->default('Commencer maintenant'),

            Color::make('Couleur du CTA', 'cta_color')
                ->hideFromIndex()
                ->default('#4CAF50'),

            // Apparence
            Color::make('Couleur principale', 'primary_color')
                ->hideFromIndex()
                ->default('#4CAF50'),

            Color::make('Couleur secondaire', 'secondary_color')
                ->hideFromIndex()
                ->default('#2196F3'),

            Image::make('Image d\'arrière-plan', 'background_image')
                ->hideFromIndex()
                ->disk('public')
                ->nullable()
                ->path('landing-pages'),

            Image::make('Logo', 'logo')
                ->hideFromIndex()
                ->disk('public')
                ->nullable()
                ->path('landing-pages'),

            // SEO
            Textarea::make('Meta Description', 'meta_description')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            Textarea::make('Meta Keywords', 'meta_keywords')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            Text::make('OG Title', 'og_title')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            Textarea::make('OG Description', 'og_description')
                ->hideFromIndex()
                ->nullable(),

            Image::make('OG Image', 'og_image')
                ->hideFromIndex()
                ->disk('public')
                ->nullable()
                ->path('landing-pages'),
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
}
