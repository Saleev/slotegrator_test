<?php

namespace App\Http\Controllers;

use App\Model\items;
use App\Model\limits;
use App\Model\prizes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::where("id", Auth::id())->first();


        $all = [
            "bonus" => $user->prizes->sum('bonus'),
            "money" => $user->prizes->sum('money'),
            "money_send" => $user->prizes->where('onsend', 1)->sum('money'),
            "item" => $user->prizes->where('id_item', '>', 0)->count(),
            "item_send" => $user->prizes->where('onsend', 1)->sum('id_item'),
            "prizes" => [],
        ];

        $user_prizes = $user->prizes->where('id_item', '>', 0);
        if($user_prizes->count() > 0) {
            $ids = [];
            foreach($user_prizes as $up){
                array_push($ids, $up->id_item);
            }

            $user_items = items::whereIn('id', $ids)->get();
            $all['user_items'] = $user_items;
        }

        $cnt = prizes::where(DB::raw('DATE(datetime_set)'), date("Y-m-d"))->where('id_user', $user->id)->count();

        $all['attempt'] = ($cnt > 0) ? 0 : 1;

        if($cnt == 0) {
            return $this->result($all, 'welcome');
        }

        return $this->result($all, 'welcome', false, 'У Вас больше нету попыток!<br /> Зайдите на сайт через 24 часа');
    }

    public function StartGame()
    {
        $columns = ["bonus", "money", "item"];
        $col = $columns[array_rand($columns, 1)];
        $res = $this->$col();
        return $this->result($res);
    }

    private function result($array, $view = '', $return = true, $message = '')
    {
        $res_array = [
            "return" => $return,
            "message" => $message,
            "result" => $array
        ];

        if($view !== ''){
            return view($view, $res_array);
        }else{
            return response()->json($res_array);
        }
    }

    private function bonus()
    {
        $c = limits::first();
        $bonus = rand(1, $c->bonus);
        $prize = new prizes();
        $prize->id_user = Auth::id();
        $prize->bonus = $bonus;
        $prize->save();

        return "Поздравляем Вы выйграли $bonus бонусов!";
    }

    private function money()
    {
        $c = limits::first();
        $money = rand(1, $c->money);
        $prize = new prizes();
        $prize->id_user = Auth::id();
        $prize->money = $money;
        $prize->save();

        return "Поздравляем Вы выйграли $money рублей!";
    }

    private function item()
    {
        //Проверка на существование записей в таблице предметов
        $cnt = items::count();
        if($cnt == 0){
            return $this->bonus();
        }

        //Если имеются предметы на складе
        $cnt = items::where('count', '>', 0)->count();
        if($cnt == 0){
            return $this->bonus();
        }

        //Если имеются записи тогда выбираем 1 запись из таблицы
        $item = items::where('count', '>', 0)->inRandomOrder()->first();

        $prize = new prizes();
        $prize->id_user = Auth::id();
        $prize->id_item = $item->id;
        $prize->save();
        return "Поздравляем Вы выйграли $item->name!";
    }
}
