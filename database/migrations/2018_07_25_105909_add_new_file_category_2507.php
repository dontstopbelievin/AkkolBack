<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFileCategory2507 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('files_categories')->insert([
            'name_ru' => 'Расчет-обоснование заявленной мощности',
            'name_kz' => 'Расчет-обоснование заявленной мощности',
            'allowed_ext' => 'doc, docx, pdf, jpg, png, tiff',
            'is_visible' => 0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
