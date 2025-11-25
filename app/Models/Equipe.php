<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 *
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
 *
 * @mixin \Eloquent
 */
class Equipe extends Model
{
    /** @use HasFactory<\Database\Factories\EquipeFactory> */
    use HasFactory;

    protected $fillable = [
        'ville',
        'categorie',
        'nb_licencies',
        'championnat',
    ];

    /**
     * @return HasMany<Joueur, $this>
     */
    public function joueurs(): HasMany
    {
        return $this->hasMany(Joueur::class);
    }

    /**
     * @return HasMany<Rencontre, $this>
     */
    public function rencontresDomicile(): HasMany
    {
        return $this->hasMany(Rencontre::class, 'equipe_domicile_id');
    }

    /**
     * @return HasMany<Rencontre, $this>
     */
    public function rencontresExterieur(): HasMany
    {
        return $this->hasMany(Rencontre::class, 'equipe_exterieur_id');
    }

    public function getVictoiresAttribute(): int
    {
        $victoiresDomicile = $this->rencontresDomicile->whereNotNull('score_domicile')->where('score_domicile', '>', 'score_exterieur')->count();
        // Note: Collection where comparison for 'score_domicile' > 'score_exterieur' is tricky with standard where().
        // Better to filter using filter() callback for complex logic on loaded collection.

        $victoiresDomicile = $this->rencontresDomicile->filter(function (Rencontre $rencontre) {
            return ! is_null($rencontre->score_domicile) && ! is_null($rencontre->score_exterieur) && $rencontre->score_domicile > $rencontre->score_exterieur;
        })->count();

        $victoiresExterieur = $this->rencontresExterieur->filter(function (Rencontre $rencontre) {
            return ! is_null($rencontre->score_domicile) && ! is_null($rencontre->score_exterieur) && $rencontre->score_exterieur > $rencontre->score_domicile;
        })->count();

        return $victoiresDomicile + $victoiresExterieur;
    }

    public function getDefaitesAttribute(): int
    {
        $defaitesDomicile = $this->rencontresDomicile->filter(function (Rencontre $rencontre) {
            return ! is_null($rencontre->score_domicile) && ! is_null($rencontre->score_exterieur) && $rencontre->score_domicile < $rencontre->score_exterieur;
        })->count();

        $defaitesExterieur = $this->rencontresExterieur->filter(function (Rencontre $rencontre) {
            return ! is_null($rencontre->score_domicile) && ! is_null($rencontre->score_exterieur) && $rencontre->score_exterieur < $rencontre->score_domicile;
        })->count();

        return $defaitesDomicile + $defaitesExterieur;
    }

    public function getNulsAttribute(): int
    {
        $nulsDomicile = $this->rencontresDomicile->filter(function (Rencontre $rencontre) {
            return ! is_null($rencontre->score_domicile) && ! is_null($rencontre->score_exterieur) && $rencontre->score_domicile === $rencontre->score_exterieur;
        })->count();

        $nulsExterieur = $this->rencontresExterieur->filter(function (Rencontre $rencontre) {
            return ! is_null($rencontre->score_domicile) && ! is_null($rencontre->score_exterieur) && $rencontre->score_exterieur === $rencontre->score_domicile;
        })->count();

        return $nulsDomicile + $nulsExterieur;
    }
}
