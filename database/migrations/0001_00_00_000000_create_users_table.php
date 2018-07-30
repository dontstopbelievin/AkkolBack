<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id')->comment('ИД');
            $table->string('name')->comment('Логин')->nullable();
            $table->string('email')->comment('Почта')->unique();
            $table->string('first_name')->comment('Имя');
            $table->string('last_name')->comment('Фамилия');
            $table->string('middle_name')->comment('Отчество')->nullable();
            $table->string('iin')->comment('ИИН')->unique()->nullable();
            $table->string('bin')->comment('БИН')->unique()->nullable();
            $table->string('company_name')->comment('Название компании')->nullable();
            $table->string('password')->comment('Пароль');
            $table->rememberToken();
            $table->timestamps();
        });
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
