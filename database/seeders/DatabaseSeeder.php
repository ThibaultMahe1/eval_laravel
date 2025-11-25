<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Définition des rôles et permissions
        Bouncer::allow('admin')->to(['gerer-equipes', 'gerer-joueurs', 'gerer-rencontres']);
        Bouncer::allow('arbitre')->to('saisir-resultats');

        // Création d'un utilisateur Admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        Bouncer::assign('admin')->to($admin);

        // Création d'un utilisateur Arbitre
        $arbitre = User::factory()->create([
            'name' => 'Arbitre User',
            'email' => 'arbitre@example.com',
        ]);
        Bouncer::assign('arbitre')->to($arbitre);

        // Création de 4 équipes
        $equipes = \App\Models\Equipe::factory()->count(4)->create([
            'categorie' => 'Senior', // Force same category for matches
        ]);

        // Pour chaque équipe, créer 10 joueurs
        foreach ($equipes as $equipe) {
            \App\Models\Joueur::factory()->count(10)->create([
                'equipe_id' => $equipe->id,
            ]);

            // Mettre à jour le nombre de licenciés
            $equipe->update(['nb_licencies' => 10]);
        }

        // Création de 8 matchs aléatoires entre ces équipes
        for ($i = 0; $i < 8; $i++) {
            // Pick 2 random distinct teams
            $matchEquipes = $equipes->random(2);

            \App\Models\Rencontre::factory()->create([
                'equipe_domicile_id' => $matchEquipes[0]->id,
                'equipe_exterieur_id' => $matchEquipes[1]->id,
                'categorie' => 'Senior',
                'score_domicile' => rand(0, 20),
                'score_exterieur' => rand(0, 20),
            ]);
        }
    }
}
