<?php

namespace App\Http\Controllers;

use App\Model\items;
use App\Model\limits;
use App\Model\prize_bonus;
use App\Model\prize_items;
use App\Model\prize_money;
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

        $user_items = [];
        foreach($user->prizeItems as $pi){
            //$ui = new stdClass();
            $ui = $pi->item;
            $ui->prize_id = $pi->id;
            $user_items[] = $ui;
        }

        $all = [
            "bonus" => $user->prizeBonuses->sum('bonus'),
            "money" => $user->prizeMoneys->sum('money'),
            "money_send" => $user->prizeMoneys->where('onsend', 1)->sum('money'),
            "item" => $user->prizeItems->count(),
            "item_send" => $user->prizeItems->where('onsend', 1)->count(),
            "user_items" => $user_items,
        ];

        $cnt = $user->prizes->where(DB::raw('DATE(datetime_set)'), 'DATE(NOW())')->count();

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

        $p = new prize_bonus();
        $p->id_user = Auth::id();
        $p->bonus = $bonus;
        $p->save();

        $prizes = new prizes();
        $prizes->id_user = Auth::id();
        $prizes->save();

        return "Поздравляем Вы выйграли $bonus бонусов!";
    }

    private function money()
    {
        $c = limits::first();
        $money = rand(1, $c->money);

        $p = new prize_money();
        $p->id_user = Auth::id();
        $p->money = $money;
        $p->save();

        $prizes = new prizes();
        $prizes->id_user = Auth::id();
        $prizes->save();

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

        $p = new prize_items();
        $p->id_user = Auth::id();
        $p->id_item = $item->id;
        $p->save();

        $prizes = new prizes();
        $prizes->id_user = Auth::id();
        $prizes->save();

        return "Поздравляем Вы выйграли $item->name!";
    }

    public function Exchange(Request $request)
    {
        if($request->has('rate_bonus')){
            $id = $request->input('rate_bonus');
            $prize_items = prize_items::find($id);
            $bonus = $prize_items->item->bonus_rate;

            $p = new prize_bonus();
            $p->id_user = Auth::id();
            $p->bonus = $bonus;
            $p->save();

            $prize_items->delete();
            return $this->result('Отлично! Вы обменяли '.$prize_items->item->name.' на бонусы!');
        }

        if($request->has('rate_money')){
            $id = $request->input('rate_money');
            $prize_items = prize_items::find($id);
            $money = $prize_items->item->money_rate;

            $p = new prize_money();
            $p->id_user = Auth::id();
            $p->money = $money;
            $p->save();

            $prize_items->delete();
            return $this->result('Отлично! Вы обменяли '.$prize_items->item->name.' на деньги!');
        }

        return $this->result('Ошибка запроса!');
    }
}
