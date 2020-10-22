<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = 'prizes';
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestampTz('datetime_set')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Дата получения приза');
            $table->integer('bonus')->default(0)->comment('Кол-во полученных бонусов');
            $table->float('money', 8, 2)->default(0)->comment('Сумма выигранных денег');
            $table->integer('id_item')->default(0);
            $table->integer('onsend')->default(0)->comment('Статус отправки 0 - не отправлен 1 отправлен');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tablename` comment 'Полученные призы пользователя'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
