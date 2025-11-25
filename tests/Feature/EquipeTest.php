<?php

use App\Models\Equipe;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

test('la page index est affichée', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('equipes.index'));

    $response->assertOk();
});

test('la page de création est affichée pour l\'admin', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-equipes');

    $response = $this->actingAs($user)->get(route('equipes.create'));

    $response->assertOk();
});

test('la page de création est interdite pour les non-admins', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('equipes.create'));

    $response->assertForbidden();
});

test('l\'admin peut créer une équipe', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-equipes');

    $equipeData = [
        'ville' => 'Paris',
        'categorie' => 'Senior',
        'championnat' => 'Ligue 1',
    ];

    $response = $this->actingAs($user)->post(route('equipes.store'), $equipeData);

    $response->assertRedirect(route('equipes.index'));
    $this->assertDatabaseHas('equipes', $equipeData);
});

test('le non-admin ne peut pas créer d\'équipe', function () {
    $user = User::factory()->create();

    $equipeData = [
        'ville' => 'Paris',
        'categorie' => 'Senior',
        'championnat' => 'Ligue 1',
    ];

    $response = $this->actingAs($user)->post(route('equipes.store'), $equipeData);

    $response->assertForbidden();
});

test('la page d\'édition est affichée pour l\'admin', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-equipes');
    $equipe = Equipe::factory()->create();

    $response = $this->actingAs($user)->get(route('equipes.edit', $equipe));

    $response->assertOk();
});

test('l\'admin peut mettre à jour une équipe', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-equipes');
    $equipe = Equipe::factory()->create();

    $updatedData = [
        'ville' => 'Lyon',
        'categorie' => 'Junior',
        'championnat' => 'Ligue 2',
    ];

    $response = $this->actingAs($user)->put(route('equipes.update', $equipe), $updatedData);

    $response->assertRedirect(route('equipes.index'));
    $this->assertDatabaseHas('equipes', $updatedData);
});

test('l\'admin peut supprimer une équipe', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-equipes');
    $equipe = Equipe::factory()->create();

    $response = $this->actingAs($user)->delete(route('equipes.destroy', $equipe));

    $response->assertRedirect(route('equipes.index'));
    $this->assertDatabaseMissing('equipes', ['id' => $equipe->id]);
});

test('les statistiques de l\'équipe sont calculées correctement', function () {
    $user = User::factory()->create();
    $equipe = Equipe::factory()->create(['categorie' => 'Senior']);
    $adversaire = Equipe::factory()->create(['categorie' => 'Senior']);

    // Victoire Domicile
    \App\Models\Rencontre::factory()->create([
        'equipe_domicile_id' => $equipe->id,
        'equipe_exterieur_id' => $adversaire->id,
        'score_domicile' => 2,
        'score_exterieur' => 1,
        'categorie' => 'Senior',
    ]);

    // Défaite Extérieur
    \App\Models\Rencontre::factory()->create([
        'equipe_domicile_id' => $adversaire->id,
        'equipe_exterieur_id' => $equipe->id,
        'score_domicile' => 3,
        'score_exterieur' => 0,
        'categorie' => 'Senior',
    ]);

    // Nul Domicile
    \App\Models\Rencontre::factory()->create([
        'equipe_domicile_id' => $equipe->id,
        'equipe_exterieur_id' => $adversaire->id,
        'score_domicile' => 1,
        'score_exterieur' => 1,
        'categorie' => 'Senior',
    ]);

    // Victoire Extérieur
    \App\Models\Rencontre::factory()->create([
        'equipe_domicile_id' => $adversaire->id,
        'equipe_exterieur_id' => $equipe->id,
        'score_domicile' => 0,
        'score_exterieur' => 1,
        'categorie' => 'Senior',
    ]);

    // Refresh model to get new relations
    $equipe->refresh();

    // Total Victoires: 1 (Dom) + 1 (Ext) = 2
    // Total Défaites: 1 (Ext) = 1
    // Total Nuls: 1 (Dom) = 1

    expect($equipe->victoires)->toBe(2);
    expect($equipe->defaites)->toBe(1);
    expect($equipe->nuls)->toBe(1);
});
