<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = 'items';
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Название');
            $table->integer('bonus_rate')->comment('Числовое значение конвертации в бонусы');
            $table->float('money_rate')->comment( 'Числовое значение конвертации в деньги');
            $table->integer('count')->default(0)->comment( 'Общее кол-во имеющихся предметов');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tablename` comment 'Список призовых предметов'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
