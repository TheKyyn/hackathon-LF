<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class DuplicateLandingPage extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $duplicatedLandings = [];

        foreach ($models as $model) {
            $clone = $model->duplicate();

            // Si un titre personnalisé est fourni, l'utiliser
            if (!empty($fields->new_title)) {
                $clone->title = $fields->new_title;
                $clone->save();
            }

            $duplicatedLandings[] = $clone;
        }

        return ActionResponse::message('La landing page a été dupliquée avec succès sous le titre : ' . $duplicatedLandings[0]->title);
    }

    /**
     * Get the displayable name of the action.
     */
    public function name(): string
    {
        return __('Dupliquer la landing page');
    }

    /**
     * Determine where this action should be available.
     */
    public function onlyOnDetail($value = true): self
    {
        $this->showOnlyOnDetail = false;
        return $this;
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Nouveau titre', 'new_title')
                ->help('Si laissé vide, le titre sera "[Titre original] (copie)"')
                ->nullable(),
        ];
    }
}
