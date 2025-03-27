<?php

namespace App\Console\Commands;

use App\Services\TwilioService;
use Illuminate\Console\Command;

class TestTwilioSMS extends Command
{
    protected $signature = 'twilio:test {phone} {message?}';
    protected $description = 'Envoie un SMS de test via Twilio';

    public function handle(TwilioService $twilio)
    {
        $phone = $this->argument('phone');
        $message = $this->argument('message') ?? 'Ceci est un message de test depuis notre application Laravel!';

        $this->info('Envoi du SMS en cours...');

        if ($twilio->sendSMS($phone, $message)) {
            $this->info('SMS envoyé avec succès!');
        } else {
            $this->error('Erreur lors de l\'envoi du SMS.');
        }
    }
}
