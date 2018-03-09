<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileSignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('files_categories')->insert([
            [
                'name_ru' => 'XML Водоснабжение',
                'name_kz' => 'XML Водоснабжение',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'XML Газоснабжение',
                'name_kz' => 'XML Газоснабжение',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'XML Электроснабжение',
                'name_kz' => 'XML Электроснабжение',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'XML Теплоснабжение',
                'name_kz' => 'XML Теплоснабжение',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'XML Телефонизация',
                'name_kz' => 'XML Телефонизация',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'XML Отдел АПЗ',
                'name_kz' => 'XML Отдел АПЗ',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name_ru' => 'XML Главный архитектор',
                'name_kz' => 'XML Главный архитектор',
                'allowed_ext' => 'xml',
                'is_visible' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('files_items_types')->insert([
            [
                'name' => 'Ответ от отдела АПЗ',
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
        DB::table('files_categories')->where([
            'name_ru' => 'XML Водоснабжение',
            'name_kz' => 'XML Водоснабжение',
            'allowed_ext' => 'xml',
        ])->delete();

        DB::table('files_categories')->where([
            'name_ru' => 'XML Газоснабжение',
            'name_kz' => 'XML Газоснабжение',
            'allowed_ext' => 'xml',
        ])->delete();

        DB::table('files_categories')->where([
            'name_ru' => 'XML Электроснабжение',
            'name_kz' => 'XML Электроснабжение',
            'allowed_ext' => 'xml',
        ])->delete();

        DB::table('files_categories')->where([
            'name_ru' => 'XML Теплоснабжение',
            'name_kz' => 'XML Теплоснабжение',
            'allowed_ext' => 'xml',
        ])->delete();

        DB::table('files_categories')->where([
            'name_ru' => 'XML Телефонизация',
            'name_kz' => 'XML Телефонизация',
            'allowed_ext' => 'xml',
        ])->delete();

        DB::table('files_categories')->where([
            'name_ru' => 'XML Отдел АПЗ',
            'name_kz' => 'XML Отдел АПЗ',
            'allowed_ext' => 'xml',
        ])->delete();

        DB::table('files_categories')->where([
            'name_ru' => 'XML Главный архитектор',
            'name_kz' => 'XML Главный архитектор',
            'allowed_ext' => 'xml',
        ])->delete();
    }
}
