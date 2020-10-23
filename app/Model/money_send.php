<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property float $money
 * @property string $id_tranzaction
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class money_send extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'money_send';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'money', 'id_tranzaction', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
