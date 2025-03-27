<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un nouvel utilisateur pour se connecter à Nova';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('Quel est le nom de l\'utilisateur?', 'Admin');
        $email = $this->argument('email') ?? $this->ask('Quel est l\'email de l\'utilisateur?', 'admin@example.com');
        $password = $this->argument('password') ?? $this->secret('Quel est le mot de passe?') ?? 'password123';

        if (User::where('email', $email)->exists()) {
            $this->error("Un utilisateur avec l'email '$email' existe déjà.");
            return 1;
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        $this->info("L'utilisateur '$name' a été créé avec succès avec l'email '$email'.");
        $this->info("Vous pouvez maintenant vous connecter à Nova avec ces identifiants.");

        return 0;
    }
}
