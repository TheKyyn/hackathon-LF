<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Envoyer des rappels de rendez-vous 24h avant le rendez-vous
        $schedule->command('app:send-appointment-reminders 24')
                 ->hourly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/appointment-reminders.log'));

        // Envoyer des rappels de rendez-vous 1h avant le rendez-vous
        $schedule->command('app:send-appointment-reminders 1')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/appointment-reminders.log'));

        // Envoyer des confirmations pour les rendez-vous récemment créés
        $schedule->command('app:send-appointment-confirmations --hours=1')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/appointment-confirmations.log'));

        // Vérifier les nouveaux rendez-vous toutes les 5 minutes
        $schedule->command('calendly:check-appointments')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/calendly-appointments.log'));

        // Envoyer les rappels de rendez-vous toutes les heures
        $schedule->command('calendly:send-reminders')
                 ->hourly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/calendly-reminders.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
