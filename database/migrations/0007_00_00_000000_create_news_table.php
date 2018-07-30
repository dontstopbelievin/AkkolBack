<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 150);
            $table->string('description', 150);
            $table->text('text');
            $table->integer('heading_id')->unsigned()->comment('идентификотор рубрики')->nullable();
            $table->integer('status')->default(1);
            $table->foreign('heading_id')->references('id')->on('heading_for_news');
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
        Schema::dropIfExists('news');
    }
}
