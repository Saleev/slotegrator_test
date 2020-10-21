<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = 'item_send';
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('id_item')->comment('ID предмета');
            $table->integer('count')->comment('Кол-во отправленных предметов');
            $table->text('address')->comment('Адресс доставки');
            $table->dateTime('datetime_send', 0)->comment('Дата отправки');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tablename` comment 'Отправленные почтой предметы пользователю'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_send');
    }
}
