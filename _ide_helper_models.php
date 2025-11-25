<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $ville
 * @property string $categorie
 * @property int $nb_licencies
 * @property string $championnat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $defaites
 * @property-read int $nuls
 * @property-read int $victoires
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Joueur> $joueurs
 * @property-read int|null $joueurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rencontre> $rencontresDomicile
 * @property-read int|null $rencontres_domicile_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rencontre> $rencontresExterieur
 * @property-read int|null $rencontres_exterieur_count
 * @method static \Database\Factories\EquipeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereChampionnat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereNbLicencies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipe whereVille($value)
 * @mixin \Eloquent
 */
	class Equipe extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string $numero_telephone
 * @property string $sexe
 * @property int $equipe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Equipe $equipe
 * @method static \Database\Factories\JoueurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereEquipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereNumeroTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Joueur whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Joueur extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $categorie
 * @property int $equipe_domicile_id
 * @property int $equipe_exterieur_id
 * @property int|null $score_domicile
 * @property int|null $score_exterieur
 * @property string $date
 * @property string $heure
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Equipe $equipeDomicile
 * @property-read \App\Models\Equipe $equipeExterieur
 * @method static \Database\Factories\RencontreFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereEquipeDomicileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereEquipeExterieurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereHeure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereScoreDomicile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereScoreExterieur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rencontre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Rencontre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Ability> $abilities
 * @property-read int|null $abilities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsNot($role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

