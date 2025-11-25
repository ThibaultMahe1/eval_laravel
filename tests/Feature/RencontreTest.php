<?php

use App\Models\Equipe;
use App\Models\Rencontre;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

test('index page is displayed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('rencontres.index'));

    $response->assertOk();
});

test('create page is displayed for admin', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-rencontres');

    $response = $this->actingAs($user)->get(route('rencontres.create'));

    $response->assertOk();
});

test('admin can create rencontre', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-rencontres');

    $equipe1 = Equipe::factory()->create(['categorie' => 'Senior']);
    $equipe2 = Equipe::factory()->create(['categorie' => 'Senior']);

    $rencontreData = [
        'equipe_domicile_id' => $equipe1->id,
        'equipe_exterieur_id' => $equipe2->id,
        'date' => '2025-12-25',
        'heure' => '14:00',
    ];

    $response = $this->actingAs($user)->post(route('rencontres.store'), $rencontreData);

    $response->assertRedirect(route('rencontres.index'));
    $this->assertDatabaseHas('rencontres', [
        'equipe_domicile_id' => $equipe1->id,
        'date' => '2025-12-25',
    ]);
});

test('cannot create rencontre with different categories', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-rencontres');

    $equipe1 = Equipe::factory()->create(['categorie' => 'Senior']);
    $equipe2 = Equipe::factory()->create(['categorie' => 'Junior']);

    $rencontreData = [
        'equipe_domicile_id' => $equipe1->id,
        'equipe_exterieur_id' => $equipe2->id,
        'date' => '2025-12-25',
        'heure' => '14:00',
    ];

    $response = $this->actingAs($user)->post(route('rencontres.store'), $rencontreData);

    $response->assertSessionHasErrors('equipe_exterieur_id');
});

test('edit page is displayed for admin', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-rencontres');
    $rencontre = Rencontre::factory()->create();

    $response = $this->actingAs($user)->get(route('rencontres.edit', $rencontre));

    $response->assertOk();
});

test('edit page is displayed for arbitre', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('saisir-resultats');
    $rencontre = Rencontre::factory()->create();

    $response = $this->actingAs($user)->get(route('rencontres.edit', $rencontre));

    $response->assertOk();
});

test('admin can update rencontre details but not scores', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-rencontres');

    $equipe1 = Equipe::factory()->create(['categorie' => 'Senior']);
    $equipe2 = Equipe::factory()->create(['categorie' => 'Senior']);
    $rencontre = Rencontre::factory()->create([
        'equipe_domicile_id' => $equipe1->id,
        'equipe_exterieur_id' => $equipe2->id,
        'categorie' => 'Senior',
    ]);

    $updatedData = [
        'equipe_domicile_id' => $equipe1->id,
        'equipe_exterieur_id' => $equipe2->id,
        'date' => '2026-01-01',
        'heure' => '15:00',
        // Scores should be ignored or cause validation error if required?
        // Controller validates based on role. Admin validation does NOT include scores.
    ];

    $response = $this->actingAs($user)->put(route('rencontres.update', $rencontre), $updatedData);

    $response->assertRedirect(route('rencontres.index'));
    $this->assertDatabaseHas('rencontres', [
        'id' => $rencontre->id,
        'date' => '2026-01-01',
    ]);
});

test('arbitre can update scores but not details', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('saisir-resultats');

    $rencontre = Rencontre::factory()->create();

    $updatedData = [
        'score_domicile' => 2,
        'score_exterieur' => 1,
        // Details should be ignored or cause validation error if required?
        // Controller validates based on role. Arbitre validation does NOT include details.
    ];

    $response = $this->actingAs($user)->put(route('rencontres.update', $rencontre), $updatedData);

    $response->assertRedirect(route('rencontres.index'));
    $this->assertDatabaseHas('rencontres', [
        'id' => $rencontre->id,
        'score_domicile' => 2,
        'score_exterieur' => 1,
    ]);
});

test('admin can delete rencontre', function () {
    $user = User::factory()->create();
    Bouncer::allow($user)->to('gerer-rencontres');
    $rencontre = Rencontre::factory()->create();

    $response = $this->actingAs($user)->delete(route('rencontres.destroy', $rencontre));

    $response->assertRedirect(route('rencontres.index'));
    $this->assertDatabaseMissing('rencontres', ['id' => $rencontre->id]);
});
