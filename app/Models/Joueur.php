<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 *
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
 *
 * @mixin \Eloquent
 */
class Joueur extends Model
{
    /** @use HasFactory<\Database\Factories\JoueurFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'numero_telephone',
        'sexe',
        'equipe_id',
    ];

    /**
     * @return BelongsTo<Equipe, $this>
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }
}
