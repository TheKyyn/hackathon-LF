<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Visit extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Visit>
     */
    public static $model = \App\Models\Visit::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'ip_address', 'utm_source', 'utm_campaign', 'utm_medium'
    ];

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

            BelongsTo::make('Lead'),

            Boolean::make('Converti', 'is_converted')
                ->sortable()
                ->filterable(),

            new Panel('Informations de base', [
                Text::make('Adresse IP', 'ip_address')
                    ->sortable(),

                Text::make('Page d\'atterrissage', 'landing_page')
                    ->hideFromIndex(),

                Text::make('Référent', 'referrer_url')
                    ->hideFromIndex(),

                Text::make('Cookie', 'cookie_token')
                    ->hideFromIndex(),
            ]),

            new Panel('Paramètres UTM', [
                Text::make('Source', 'utm_source')
                    ->filterable()
                    ->sortable(),

                Text::make('Campagne', 'utm_campaign')
                    ->filterable()
                    ->sortable(),

                Text::make('Medium', 'utm_medium')
                    ->filterable()
                    ->sortable(),

                Text::make('Terme', 'utm_term')
                    ->hideFromIndex(),

                Text::make('Contenu', 'utm_content')
                    ->hideFromIndex(),
            ]),

            new Panel('Informations sur l\'appareil', [
                Text::make('Type d\'appareil', 'device_type')
                    ->filterable()
                    ->sortable(),

                Text::make('Navigateur', 'browser')
                    ->filterable()
                    ->sortable(),

                Text::make('Version', 'browser_version')
                    ->hideFromIndex(),

                Text::make('Système d\'exploitation', 'os')
                    ->filterable()
                    ->hideFromIndex(),
            ]),

            DateTime::make('Date de création', 'created_at')
                ->sortable()
                ->filterable(),

            DateTime::make('Date de mise à jour', 'updated_at')
                ->sortable()
                ->hideFromIndex(),
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
        return [];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Visites';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Visite';
    }

    /**
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    public static function group()
    {
        return 'Tracking';
    }
}
