<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property float $money
 * @property int $onsend
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class prize_money extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prize_money';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'money', 'onsend', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
