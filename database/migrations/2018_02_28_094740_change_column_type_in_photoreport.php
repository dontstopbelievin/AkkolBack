<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeInPhotoreport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photoreports', function (Blueprint $table) {
            $table->string('company_name', 255)->comment('Наименование компании')->change();
            $table->string('company_legal_address', 255)->comment('Юридический адрес компании')->change();
            $table->string('company_factual_address', 255)->comment('Дата заявки')->change();
            $table->string('photo_address', 255)->comment('Адрес рекламы')->change();
            $table->string('company_region', 255)->comment('Регион компании')->change();
            $table->string('iin', 255)->comment('ИИН')->change();
            $table->string('company_phone', 255)->comment('Телефон компании')->change();
            $table->date('start_date')->comment('Период с')->change();
            $table->date('end_date')->comment('Период до')->change();
            $table->string('comments', 255)->comment('Комментарий')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photoreports', function (Blueprint $table) {
            $table->integer('company_name')->comment('Наименование компании')->change();
            $table->integer('company_legal_address')->comment('Юридический адрес компании')->change();
            $table->integer('company_factual_address')->comment('Дата заявки')->change();
            $table->integer('photo_address')->comment('Адрес рекламы')->change();
            $table->integer('company_region')->comment('Регион компании')->change();
            $table->integer('iin')->comment('ИИН')->change();
            $table->integer('company_phone')->comment('Телефон компании')->change();
            $table->integer('start_date')->comment('Период с')->change();
            $table->integer('end_date')->comment('Период до')->change();
            $table->integer('comments')->comment('Комментарий')->change();
        });
    }
}
