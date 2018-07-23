<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewDatesForSign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('file_id')->unsigned()->comment('ИД файла');
            $table->foreign('file_id')->references('id')->on('files');
            $table->longText('sign')->comment('Подпись');
            $table->longText('cert')->comment('Открытый ключ');
            $table->timestamps();
        });

        DB::table('apz_states')->insert([
            [
                'code' => 'region_signed',
                'name' => 'Подписан районным архитектором',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'apz_signed',
                'name' => 'Подписан отделом АПЗ',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'head_signed',
                'name' => 'Подписан главным архитектором',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
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
