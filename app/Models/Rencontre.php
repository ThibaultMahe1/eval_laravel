<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 *
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
 *
 * @mixin \Eloquent
 */
class Rencontre extends Model
{
    /** @use HasFactory<\Database\Factories\RencontreFactory> */
    use HasFactory;

    protected $fillable = [
        'equipe_domicile_id',
        'equipe_exterieur_id',
        'score_domicile',
        'score_exterieur',
        'date',
        'heure',
        'categorie',
    ];

    /**
     * @return BelongsTo<Equipe, $this>
     */
    public function equipeDomicile(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_domicile_id');
    }

    /**
     * @return BelongsTo<Equipe, $this>
     */
    public function equipeExterieur(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_exterieur_id');
    }
}
