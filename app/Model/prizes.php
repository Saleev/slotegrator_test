<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property string $datetime_set
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class prizes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_user', 'datetime_set', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
