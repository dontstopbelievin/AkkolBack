<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApzStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apz_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 255)->comment('Код');
            $table->string('name', 255)->comment('Название');
            $table->timestamps();
        });

        Schema::create('apz_states_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->integer('state_id')->unsigned()->comment('ИД состояние');
            $table->foreign('state_id')->references('id')->on('apz_states');
            $table->string('comment', 255)->comment('Коментарии');
            $table->timestamps();
        });

        DB::table('apz_states')->insert([
            [
                'code' => 'to_region',
                'name' => 'Отправлен районному архитектору',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'region_approved',
                'name' => 'Одобрен районным архитектором',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'region_declined',
                'name' => 'Отклонен районным архитектором',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'to_engineer',
                'name' => 'Отправлен инженеру',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'engineer_approved',
                'name' => 'Одобрен инженером',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'engineer_declined',
                'name' => 'Отклонен инженером',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'to_providers',
                'name' => 'Отправлен провайдерам',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'water_approved',
                'name' => 'Одобрен провайдером водоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'water_declined',
                'name' => 'Отклонен провайдером водоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'gas_approved',
                'name' => 'Одобрен провайдером Газоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'gas_declined',
                'name' => 'Отклонен провайдером Газоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'electricity_approved',
                'name' => 'Одобрен провайдером электроснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'electricity_declined',
                'name' => 'Отклонен провайдером электроснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'phone_approved',
                'name' => 'Одобрен провайдером телефонизация',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'phone_declined',
                'name' => 'Отклонен провайдером телефонизация',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'heat_approved',
                'name' => 'Одобрен провайдером теплоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'heat_declined',
                'name' => 'Отклонен провайдером теплоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'to_apz',
                'name' => 'Отправлен отделу АПЗ',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'apz_approved',
                'name' => 'Одобрен отделом АПЗ',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'apz_declined',
                'name' => 'Отклонен отделом АПЗ',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'to_head',
                'name' => 'Отправлен главному архитектору',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'head_approved',
                'name' => 'Одобрен главным архитектором',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'head_declined',
                'name' => 'Отклонен главным архитектором',
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
        Schema::dropIfExists('apz_states');
        Schema::dropIfExists('apz_states_history');
    }
}
