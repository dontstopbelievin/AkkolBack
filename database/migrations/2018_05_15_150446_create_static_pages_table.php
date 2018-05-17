<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title','150')->comment('Названиие статичной страницы');
            $table->text('description')->comment('Описание страницы');
            $table->text('content')->comment('Сама страница');
            $table->integer('role_id')->unsigned()->nullable()->comment('Роль доступа');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('status')->comment('Статус на отображение в сайте');
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
        Schema::dropIfExists('static_pages');
    }
}
