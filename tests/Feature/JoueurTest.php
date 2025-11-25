<?php

use App\Models\Equipe;
use App\Models\Joueur;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

test('la page index est affichée', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('joueurs.index'));

    $response->assertOk();
});

test('la page de détails est affichée pour l\'admin', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-joueurs');
    $joueur = Joueur::factory()->create();

    $response = $this->actingAs($user)->get(route('joueurs.show', $joueur));

    $response->assertOk();
});

test('la page de détails est affichée pour l\'arbitre', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('saisir-resultats');
    $joueur = Joueur::factory()->create();

    $response = $this->actingAs($user)->get(route('joueurs.show', $joueur));

    $response->assertOk();
});

test('la page de détails est interdite pour un utilisateur non autorisé', function () {
    $user = User::factory()->create();
    $joueur = Joueur::factory()->create();

    $response = $this->actingAs($user)->get(route('joueurs.show', $joueur));

    $response->assertForbidden();
});

test('la page de création est affichée pour l\'admin', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-joueurs');

    $response = $this->actingAs($user)->get(route('joueurs.create'));

    $response->assertOk();
});

test('l\'admin peut créer un joueur', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-joueurs');
    $equipe = Equipe::factory()->create();

    $joueurData = [
        'nom' => 'Doe',
        'prenom' => 'John',
        'email' => 'john@example.com',
        'numero_telephone' => '0123456789',
        'sexe' => 'M',
        'equipe_id' => $equipe->id,
    ];

    $response = $this->actingAs($user)->post(route('joueurs.store'), $joueurData);

    $response->assertRedirect(route('joueurs.index'));
    $this->assertDatabaseHas('joueurs', ['email' => 'john@example.com']);

    // Check if licencies count incremented
    $this->assertEquals(1, $equipe->fresh()->nb_licencies);
});

test('l\'admin peut mettre à jour un joueur', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-joueurs');
    $equipe = Equipe::factory()->create();
    $joueur = Joueur::factory()->create(['equipe_id' => $equipe->id]);
    $equipe->increment('nb_licencies'); // Manually increment as factory might not trigger controller logic

    $newEquipe = Equipe::factory()->create();

    $updatedData = [
        'nom' => 'Smith',
        'prenom' => 'Jane',
        'email' => 'jane@example.com',
        'numero_telephone' => '9876543210',
        'sexe' => 'F',
        'equipe_id' => $newEquipe->id,
    ];

    $response = $this->actingAs($user)->put(route('joueurs.update', $joueur), $updatedData);

    $response->assertRedirect(route('joueurs.index'));
    $this->assertDatabaseHas('joueurs', ['email' => 'jane@example.com']);

    // Check licencies count update
    $this->assertEquals(0, $equipe->fresh()->nb_licencies); // Decremented
    $this->assertEquals(1, $newEquipe->fresh()->nb_licencies); // Incremented
});

test('l\'admin peut supprimer un joueur', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-joueurs');
    $equipe = Equipe::factory()->create();
    $joueur = Joueur::factory()->create(['equipe_id' => $equipe->id]);
    $equipe->increment('nb_licencies');

    $response = $this->actingAs($user)->delete(route('joueurs.destroy', $joueur));

    $response->assertRedirect(route('joueurs.index'));
    $this->assertDatabaseMissing('joueurs', ['id' => $joueur->id]);

    // Check licencies count decrement
    $this->assertEquals(0, $equipe->fresh()->nb_licencies);
});
