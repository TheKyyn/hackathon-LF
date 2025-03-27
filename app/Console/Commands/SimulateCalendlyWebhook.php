<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CalendlyController;
use Illuminate\Http\Request;

class SimulateCalendlyWebhook extends Command
{
    protected $signature = 'calendly:simulate {email?}';
    protected $description = 'Simule un webhook Calendly pour tester l\'intégration';

    /**
     * @var CalendlyController
     */
    protected $calendlyController;

    /**
     * Constructeur de la commande
     *
     * @param CalendlyController $calendlyController
     */
    public function __construct(CalendlyController $calendlyController)
    {
        parent::__construct();
        $this->calendlyController = $calendlyController;
    }

    public function handle()
    {
        $email = $this->argument('email') ?? 'maximeth@gmail.com';

        // Créer un lead de test ou utiliser un existant
        $lead = Lead::where('email', $email)->first();

        if (!$lead) {
            $lead = new Lead();
            $lead->first_name = 'Test';
            $lead->last_name = 'User';
            $lead->email = $email;
            $lead->phone = '+33627662449';
            $lead->save();

            $this->info("Lead de test créé avec l'email: {$email}");
        }

        // Date du rendez-vous (demain à 14h)
        $tomorrow = now()->addDay()->setHour(14)->setMinute(0);
        $appointmentDate = $tomorrow->format('Y-m-d\TH:i:s\Z');

        // Créer un payload de webhook similaire à ce que Calendly envoie
        $payload = [
            'event' => 'invitee.created',
            'payload' => [
                'invitee' => [
                    'uuid' => 'test-' . uniqid(),
                    'email' => $lead->email,
                    'name' => $lead->first_name . ' ' . $lead->last_name,
                ],
                'event' => [
                    'uuid' => 'event-' . uniqid(),
                    'start_time' => $appointmentDate,
                    'end_time' => $tomorrow->addHour()->format('Y-m-d\TH:i:s\Z'),
                ]
            ]
        ];

        $this->info('Simulation du webhook Calendly directement...');

        // Créer une requête simulée
        $request = Request::create(
            '/calendly/webhook',
            'POST',
            $payload,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        try {
            // Appeler directement le contrôleur avec la requête simulée
            $response = $this->calendlyController->webhook($request);

            // Récupérer le contenu de la réponse
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();

            $this->info('Webhook simulé avec succès!');
            $this->info('Code de réponse: ' . $statusCode);
            $this->info('Contenu de la réponse: ' . $content);

            // Vérifier que le lead a été mis à jour
            $lead->refresh();
            if ($lead->appointment_date) {
                $this->info('Le lead a bien été mis à jour avec la date de rendez-vous.');
                $this->info('Date du rendez-vous: ' . $lead->appointment_date);
            } else {
                $this->error('Le lead n\'a pas été mis à jour avec la date de rendez-vous.');
            }
        } catch (\Exception $e) {
            $this->error('Échec de la simulation du webhook Calendly.');
            $this->error('Erreur: ' . $e->getMessage());
            $this->error('Dans: ' . $e->getFile() . ' à la ligne ' . $e->getLine());
        }
    }
}
