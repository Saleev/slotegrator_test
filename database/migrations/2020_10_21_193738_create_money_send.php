<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneySend extends Migration
{
    protected $tablename = 'money_send';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->float('money', 8, 2)->comment('Отправленная сумма');
            $table->string('id_tranzaction')->comment('ID транзакции');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$this->tablename` comment 'Отправленные почтой предметы пользователю'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_send');
    }
}
