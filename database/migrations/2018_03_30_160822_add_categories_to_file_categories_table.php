<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriesToFileCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_categories', function (Blueprint $table) {
            //
            DB::table('files_categories')->insert([
                [
                    'name_ru' => 'Сканированный файл оплаты',
                    'name_kz' => 'Сканированный файл оплаты',
                    'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
                    'is_visible' => true,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
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
        Schema::table('file_categories', function (Blueprint $table) {
            //
        });
    }
}
