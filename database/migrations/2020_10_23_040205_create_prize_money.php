<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizeMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = 'prize_money';
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->float('money', 8, 2);
            $table->integer('onsend')->default(0)->comment('Статус отправки 0 - не отправлен 1 отправлен');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tablename` comment 'Таблица призовых денег'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prize_money');
    }
}
