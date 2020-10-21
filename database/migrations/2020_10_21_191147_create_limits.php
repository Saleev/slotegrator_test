<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = 'limits';
        Schema::create($tablename, function (Blueprint $table) {
            $table->integer('bonus')->comment( 'Бонус');
            $table->float('money', 8, 2)->comment( 'Деньги');
            $table->integer('items')->comment('Предмет');
        });

        DB::statement("ALTER TABLE `$tablename` comment 'Установленные лимиты призов'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limits');
    }
}
