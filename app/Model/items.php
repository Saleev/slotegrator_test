<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $bonus_rate
 * @property float $money_rate
 * @property int $count
 * @property string $created_at
 * @property string $updated_at
 * @property PrizeItem[] $prizeItems
 */
class items extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'bonus_rate', 'money_rate', 'count', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prizeItems()
    {
        return $this->hasMany('App\Model\prize_item', 'id_item');
    }
}
