<?php
namespace App\Helpers;

use App\User;
use App\Model\prize_money;

class OnMoneySend
{
    public static function money()
    {
        $user = User::whereNotNull('card_num')->first();
        $cl = new \stdClass();

        $moneys = $user->prizeMoneys->first();
        $cl->id_user = $user->id;
        $cl->card_num = $user->card_num;
        $cl->money = $moneys->money;
        $cl->id_prize = $moneys->id;
        return $cl;
    }

    public static function SaveSendMoney($id_prize)
    {
        $prize_money = prize_money::find($id_prize)->first();
        $prize_money->onsend = 1;
        $prize_money->save();

        return true;
    }
}
