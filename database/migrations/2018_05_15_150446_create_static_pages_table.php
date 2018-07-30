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
            $table->text('title_ru','150')->comment('Названиие на русском языке');
            $table->text('title_kk', '150')->comment('Название на казахском языке');
            $table->text('description_ru')->comment('Описание на русском языке');
            $table->text('description_kk')->comment('Описание на казахском языке');
            $table->text('content_ru')->comment('Контент на русском');
            $table->text('content_kk')->comment('Контент на казахском');
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
