<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncLeadsWithCentralPlatform extends Command
{
    /**
     * Signature de la commande avec options.
     *
     * @var string
     */
    protected $signature = 'leads:sync-platform
                            {--id= : ID spécifique d\'un lead à synchroniser}
                            {--limit= : Limite le nombre de leads à synchroniser}
                            {--from= : Date de début (format Y-m-d)}
                            {--to= : Date de fin (format Y-m-d)}';

    /**
     * Description de la commande.
     *
     * @var string
     */
    protected $description = 'Synchronise les leads existants avec la plateforme centrale';

    /**
     * Exécute la commande.
     */
    public function handle(): int
    {
        // Initialiser la requête sur le modèle Lead
        $query = Lead::query();

        // Filtrer par ID si spécifié
        if ($this->option('id')) {
            $query->where('id', $this->option('id'));
        }

        // Filtrer par date si spécifié
        if ($this->option('from')) {
            $query->where('created_at', '>=', $this->option('from'));
        }

        if ($this->option('to')) {
            $query->where('created_at', '<=', $this->option('to') . ' 23:59:59');
        }

        // Appliquer la limite si spécifiée
        if ($this->option('limit')) {
            $query->limit($this->option('limit'));
        }

        // Récupérer les leads
        $leads = $query->get();
        $totalLeads = $leads->count();
        $successCount = 0;
        $failCount = 0;

        if ($totalLeads === 0) {
            $this->info('Aucun lead à synchroniser.');
            return 0;
        }

        $this->info("Synchronisation de {$totalLeads} leads avec la plateforme centrale...");

        // Synchroniser chaque lead
        foreach ($leads as $lead) {
            try {
                $result = $lead->syncWithCentralPlatform();

                if ($result) {
                    $successCount++;
                    $this->info("Lead #{$lead->id} synchronisé avec succès.");
                } else {
                    $failCount++;
                    $this->error("Échec de la synchronisation du lead #{$lead->id}.");
                }
            } catch (\Exception $e) {
                $failCount++;
                Log::error("Exception lors de la synchronisation du lead #{$lead->id}", [
                    'exception' => $e->getMessage()
                ]);
                $this->error("Erreur lors de la synchronisation du lead #{$lead->id}: " . $e->getMessage());
            }
        }

        $this->info("Synchronisation terminée: {$successCount} réussis, {$failCount} échecs.");

        return $failCount > 0 ? 1 : 0;
    }
}
