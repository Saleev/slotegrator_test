<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property int $id_item
 * @property int $onsend
 * @property string $created_at
 * @property string $updated_at
 * @property Item $item
 * @property User $user
 * @property ItemSend[] $itemSends
 */
class prize_items extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_user', 'id_item', 'onsend', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('App\Model\items', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemSends()
    {
        return $this->hasMany('App\Model\item_send', 'id_pitem');
    }
}
