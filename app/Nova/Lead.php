<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Badge;

class Lead extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Lead>
     */
    public static $model = \App\Models\Lead::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'email', 'phone', 'first_name', 'last_name',
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

            // Informations personnelles
            Text::make('Prénom', 'first_name')
                ->sortable(),

            Text::make('Nom', 'last_name')
                ->sortable(),

            Text::make('Email', 'email')
                ->sortable()
                ->rules('required', 'email'),

            Text::make('Téléphone', 'phone')
                ->sortable()
                ->rules('required'),

            Text::make('Code Postal', 'postal_code')
                ->hideFromIndex(),

            // Informations sur le projet
            Select::make('Facture d\'énergie', 'energy_bill')
                ->options([
                    '0-100' => '0-100€',
                    '100-200' => '100-200€',
                    '200-300' => '200-300€',
                    '300+' => '300€ et plus',
                ])
                ->hideFromIndex(),

            Select::make('Type de propriété', 'property_type')
                ->options([
                    'house' => 'Maison',
                    'apartment' => 'Appartement',
                ])
                ->hideFromIndex(),

            Boolean::make('Propriétaire', 'is_owner')
                ->hideFromIndex(),

            // Statuts et suivi
            Select::make('Statut', 'status')
                ->options([
                    'new' => 'Nouveau',
                    'contacted' => 'Contacté',
                    'qualified' => 'Qualifié',
                    'not_interested' => 'Pas intéressé',
                ])
                ->sortable(),

            Select::make('Statut de vente', 'sale_status')
                ->options([
                    'pending' => 'En attente',
                    'to_sell' => 'À vendre',
                    'sold' => 'Vendu',
                    'cancelled' => 'Annulé',
                ])
                ->sortable(),

            Textarea::make('Commentaire', 'comment')
                ->hideFromIndex()
                ->alwaysShow(),

            // Marketing et tracking
            Boolean::make('Opt-in Marketing', 'optin')
                ->sortable(),

            Text::make('IP', 'ip_address')
                ->hideFromIndex(),

            Text::make('Source UTM', 'utm_source')
                ->hideFromIndex(),

            Text::make('Medium UTM', 'utm_medium')
                ->hideFromIndex(),

            Text::make('Campagne UTM', 'utm_campaign')
                ->hideFromIndex(),

            // Timestamps
            DateTime::make('Créé le', 'created_at')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Mis à jour le', 'updated_at')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new Metrics\VisitsBySourceMetric(),
            new Metrics\VisitsTrendMetric(),
            new Metrics\VisitToLeadConversionMetric(),
        ];
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
}
