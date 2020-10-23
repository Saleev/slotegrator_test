<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $bonus
 * @property float $money
 * @property int $items
 */
class limits extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['bonus', 'money', 'items'];

}
