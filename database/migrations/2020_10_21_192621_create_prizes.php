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
