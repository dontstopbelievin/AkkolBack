<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('question')->comment('Содержит вопросы пользователей к админу');
            $table->text('answer')->nullable()->comment('Ответы от администратора');
            $table->integer('status')->comment('1 - на рассмотрении, 2 - отвеченный');
            $table->integer('user_id')->unsigned()->nullable()->comment('пользователь отправивший смс');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
