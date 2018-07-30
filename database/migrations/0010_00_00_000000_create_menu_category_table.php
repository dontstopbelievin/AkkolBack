<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_category', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name_kk')->comment('Имя Категории на казахском');
            $table->text('name_ru')->comment('Имя Категории на русском');
            $table->timestamps();
            $table->SoftDeletes();
        });

        Schema::table('menu_category', function (Blueprint $table) {
            //
            DB::table('menu_category')->insert([
                [
                    'name_kk' => 'Басқару жайлы',
                    'name_ru' => 'Об Управлении'
                ],
                [
                    'name_kk' => 'Мемлекеттік қызмет',
                    'name_ru' => 'Государственные услуги'
                ],
                [
                    'name_kk' => 'Мемлекеттік сатып алу',
                    'name_ru' => 'Государственные закупки'
                ],
                [
                    'name_kk' => 'Сауалнама',
                    'name_ru' => 'Опрос'
                ]
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_category');
    }
}
