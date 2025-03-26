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
        'id', 'first_name', 'last_name', 'email', 'phone', 'postal_code',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Prénom', 'first_name')
                ->sortable(),

            Text::make('Nom', 'last_name')
                ->sortable(),

            Text::make('Email', 'email')
                ->sortable()
                ->rules('email', 'max:254'),

            Text::make('Téléphone', 'phone')
                ->sortable(),

            Text::make('Code Postal', 'postal_code')
                ->sortable()
                ->hideFromIndex(),

            Select::make('Type de Chauffage', 'energy_type')
                ->options([
                    'EDF' => 'EDF',
                    'Gaz' => 'Gaz',
                    'Fioul' => 'Fioul',
                    'Autre' => 'Autre',
                ])
                ->hideFromIndex(),

            Text::make('Facture Énergétique', 'energy_bill')
                ->hideFromIndex(),

            Boolean::make('Propriétaire', 'is_owner')
                ->hideFromIndex(),

            Badge::make('Statut d\'Appel', 'call_status')
                ->map([
                    'à appeler' => 'warning',
                    'appelé' => 'success',
                    'rappeler' => 'info',
                ])
                ->labels([
                    'à appeler' => 'À appeler',
                    'appelé' => 'Appelé',
                    'rappeler' => 'Rappeler',
                ])
                ->sortable(),

            Select::make('Statut d\'Appel', 'call_status')
                ->options([
                    'à appeler' => 'À appeler',
                    'appelé' => 'Appelé',
                    'rappeler' => 'Rappeler',
                ])
                ->onlyOnForms(),

            Badge::make('Statut de Vente', 'sale_status')
                ->map([
                    'à vendre' => 'warning',
                    'vendu' => 'success',
                    'annulé' => 'danger',
                ])
                ->labels([
                    'à vendre' => 'À vendre',
                    'vendu' => 'Vendu',
                    'annulé' => 'Annulé',
                ])
                ->sortable(),

            Select::make('Statut de Vente', 'sale_status')
                ->options([
                    'à vendre' => 'À vendre',
                    'vendu' => 'Vendu',
                    'annulé' => 'Annulé',
                ])
                ->onlyOnForms(),

            Textarea::make('Commentaire', 'comment')
                ->alwaysShow()
                ->rows(3),

            Boolean::make('Opt-in Marketing', 'optin')
                ->hideFromIndex(),

            Text::make('ID Airtable', 'airtable_id')
                ->onlyOnDetail(),

            DateTime::make('Créé le', 'created_at')
                ->sortable()
                ->format('DD/MM/YYYY HH:mm')
                ->hideFromIndex(),

            DateTime::make('Modifié le', 'updated_at')
                ->sortable()
                ->format('DD/MM/YYYY HH:mm')
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [
            new Metrics\TotalLeads(),
            new Metrics\LeadsPerDay(),
            new Metrics\LeadsByStatus(),
            new Metrics\LeadsByCallStatus(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new Filters\LeadCallStatusFilter,
            new Filters\LeadSaleStatusFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
