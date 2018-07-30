<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_menu')->unsigned()->comment('ID категории меню');
            $table->foreign('id_menu')->references('id')->on('menu_category');
            $table->integer('id_page')->unsigned()->nullable()->comment('ID страницы');
            $table->foreign('id_page')->references('id')->on('static_pages');
            $table->text('title_kk')->comment('Название пункта меню на казахском');
            $table->text('title_ru')->comment('Название пункта меню на русском');
            $table->integer('type')->comment('тип элем. 1 = страница, 2 = ссылка');
            $table->integer('role_id')->unsigned()->nullable()->comment('Роль доступа');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->text('link')->nullable()->comment('ссылка на сторонний ресурс');
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
        Schema::dropIfExists('menu_item');
    }
}
