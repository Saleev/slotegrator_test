<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property int $id_pitem
 * @property int $count
 * @property string $address
 * @property string $datetime_send
 * @property string $created_at
 * @property string $updated_at
 * @property PrizeItem $prizeItem
 * @property User $user
 */
class item_send extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_send';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'id_pitem', 'count', 'address', 'datetime_send', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prizeItem()
    {
        return $this->belongsTo('App\Model\prize_item', 'id_pitem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
