<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadingForNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heading_for_news', function (Blueprint $table) {
            $table->increments('id')->comment('Идентификационный номер рубрики');
            $table->string('name','200')->comment('Имя определенной рубрики');
            $table->timestamps();
        });



        DB::table('heading_for_news')->insert([
            [ 'name' => 'Новости управления' ],
            [ 'name' => 'СМИ о нас' ],
            [ 'name' => 'Кадры решают все' ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heading_for_news');
    }
}
