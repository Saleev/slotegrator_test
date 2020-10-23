<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('isadmin')->default(0)->comment('Является администратором');
            $table->string('card_num')->nullable()->comment('Номер карточки');
            $table->text('address')->nullable()->comment('Адрес доставки');
        });

        DB::table('users')->insert(
            array(
                'name' => 'admin',
                'email' => 'admin@game.com',
                'password' => Hash::make('12345678'),
                'isadmin' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
