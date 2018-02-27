<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_categories', function (Blueprint $table) {
            $table->increments('id')->comment('ИД');
            $table->string('name_ru', 255)->comment('Название на русском');
            $table->string('name_kz', 255)->comment('Название на казахском');
            $table->string('description_ru', 255)->comment('Описание на русском')->nullable();
            $table->string('description_kz', 255)->comment('Описание на казахском')->nullable();
            $table->string('allowed_ext', 255)->comment('Разрешенные расширение файлов');
            $table->boolean('is_visible')->comment('Флаг видимости');
            $table->timestamps();
        });

        Schema::create('files_items_types', function (Blueprint $table) {
            $table->increments('id')->comment('ИД');
            $table->string('name', 255)->comment('Название');
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id')->comment('ИД');
            $table->string('name', 255)->comment('Название');
            $table->string('description', 255)->comment('Описание')->nullable();
            $table->string('url', 255)->comment('Ссылка на файл');
            $table->string('hash', 255)->unique()->comment('Хэш файла');
            $table->string('extension', 255)->comment('Расширение');
            $table->string('content_type', 255)->comment('Тип');
            $table->string('size', 255)->comment('Размер');
            $table->integer('category_id')->unsigned()->comment('ИД категории')->nullable();
            $table->foreign('category_id')->references('id')->on('files_categories');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('files_items', function (Blueprint $table) {
            $table->increments('id')->comment('ИД');
            $table->integer('file_id')->unsigned()->comment('ИД файла')->nullable();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('CASCADE');
            $table->string('item_id')->comment('ИД родителя');
            $table->integer('item_type_id')->unsigned()->comment('ИД типа связи')->nullable();
            $table->foreign('item_type_id')->references('id')->on('files_items_types');
            $table->timestamps();
        });

        DB::table('files_categories')->insert([
            [
                'name_ru' => 'Эскизный проект',
                'name_kz' => 'Эскизный проект',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Архитектурно-планировочное задание',
                'name_kz' => 'Архитектурно-планировочное задание',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Удостверение личности',
                'name_kz' => 'Удостверение личности',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Удостверение личности поверенного',
                'name_kz' => 'Удостверение личности поверенного',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Доверенность',
                'name_kz' => 'Доверенность',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Бюджетное планирование',
                'name_kz' => 'Бюджетное планирование',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Инструкция пользователя',
                'name_kz' => 'Инструкция пользователя',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Реквизиты',
                'name_kz' => 'Реквизиты',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Утвержденное задание',
                'name_kz' => 'Утвержденное задание',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Правоустанавл. документ',
                'name_kz' => 'Правоустанавл. документ',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Мотивированный отказ',
                'name_kz' => 'Мотивированный отказ',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'Техническое условие',
                'name_kz' => 'Техническое условие',
                'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                'is_visible' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
        ]);

        DB::table('files_items_types')->insert([
            [
                'name' => 'Архитектурно-планировочное задание',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Эскизный проект',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Фотоотчеты',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ТУ/МО Водоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ТУ/МО Газоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ТУ/МО Телефонизация',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ТУ/МО Электроснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ТУ/МО Теплоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'ТУ/МО Главный архитектор',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_categories');
        Schema::dropIfExists('files');
        Schema::dropIfExists('files_items');
    }
}
