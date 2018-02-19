<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApzResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ')->nullable();
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_active')->default(false)->comment('Флаг активности');
            $table->timestamps();
        });

        Schema::create('commissions_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commission_id')->unsigned()->comment('ИД комиссии')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_done')->default(false)->comment('Завершен');
            $table->timestamps();
        });

        Schema::create('apz_provider_water_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commission_id')->unsigned()->comment('ИД комиссии')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('file_id')->unsigned()->comment('ИД файла')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('response_text', 255)->comment('Ответ')->nullable();
            $table->string('comments', 255)->comment('Комментарий')->nullable();
            $table->boolean('response')->comment('Флаг принятие');
            $table->float('gen_water_req', 11, 3)->comment('Общая потребность в воде');
            $table->float('drinking_water', 11, 3)->comment('На хозпитьевые нужды');
            $table->float('prod_water', 11, 3)->comment('На производственные нужды');
            $table->float('fire_fighting_water_in', 11, 3)->comment('Потребные расходы внутреннего пожаротушения');
            $table->float('fire_fighting_water_out', 11, 3)->comment('Потребные расходы наружного пожаротушения');
            $table->string('connection_point', 255)->comment('Точка подключения')->nullable();
            $table->string('recommendation', 255)->comment('Рекомендация')->nullable();
            $table->string('doc_number', 255)->comment('Номер документа');
            $table->timestamps();
        });

        Schema::create('apz_provider_gas_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commission_id')->unsigned()->comment('ИД комиссии')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('file_id')->unsigned()->comment('ИД файла')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('response_text', 255)->comment('Ответ')->nullable();
            $table->string('comments', 255)->comment('Комментарий')->nullable();
            $table->boolean('response')->comment('Флаг принятие');
            $table->string('connection_point', 255)->comment('Точка подключения')->nullable();
            $table->float('gas_pipe_diameter', 11,3)->comment('Диаметр газопровода');
            $table->float('assumed_capacity', 11,3)->comment('Предполагаемый объем');
            $table->string('reconsideration', 255)->comment('Предусмотрение')->nullable();
            $table->string('doc_number', 255)->comment('Номер документа');
            $table->timestamps();
        });

        Schema::create('apz_provider_heat_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commission_id')->unsigned()->comment('ИД комиссии')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('file_id')->unsigned()->comment('ИД файла')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('response_text', 255)->comment('Ответ')->nullable();
            $table->string('comments', 255)->comment('Комментарий')->nullable();
            $table->boolean('response')->comment('Флаг принятие');
            $table->string('resource', 255)->comment('Источник')->nullable();
            $table->string('trans_pressure', 255)->comment('Давление теплоносителя в тепловой камере')->nullable();
            $table->string('load_contract_num', 255)->comment('Тепловые нагрузки по договору')->nullable();
            $table->string('main_in_contract', 255)->comment('Отопление')->nullable();
            $table->string('ven_in_contract', 255)->comment('Вентиляция')->nullable();
            $table->string('water_in_contract', 255)->comment('Горячее водоснабжение')->nullable();
            $table->string('connection_point', 255)->comment('Точка подключения')->nullable();
            $table->string('addition', 255)->comment('Дополнительное')->nullable();
            $table->string('doc_number', 255)->comment('Номер документа');
            $table->timestamps();
        });

        Schema::create('apz_provider_electricity_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commission_id')->unsigned()->comment('ИД комиссии')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('file_id')->unsigned()->comment('ИД файла')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('response_text', 255)->comment('Ответ')->nullable();
            $table->string('comments', 255)->comment('Комментарий')->nullable();
            $table->boolean('response')->comment('Флаг принятие');
            $table->string('req_power', 255)->comment('Требуемая мощность')->nullable();
            $table->string('phase', 255)->comment('Характер нагрузки')->nullable();
            $table->string('safe_category', 255)->comment('Категория по надежности ')->nullable();
            $table->string('connection_point', 255)->comment('Точка подключения')->nullable();
            $table->string('recommendation', 255)->comment('Рекомендация')->nullable();
            $table->string('doc_number', 255)->comment('Номер документа');
            $table->timestamps();
        });

        Schema::create('apz_provider_phone_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commission_id')->unsigned()->comment('ИД комиссии')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('file_id')->unsigned()->comment('ИД файла')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('response_text', 255)->comment('Ответ')->nullable();
            $table->string('comments', 255)->comment('Комментарий')->nullable();
            $table->boolean('response')->comment('Флаг принятие');
            $table->float('service_num', 11,3)->comment('Количество ОТА и услуг в разбивке физ.лиц и юр.лиц')->nullable();
            $table->string('capacity', 255)->comment('Телефонная емкость')->nullable();
            $table->string('sewage', 255)->comment('Планируемая телефонная канализация')->nullable();
            $table->string('client_wishes', 255)->comment('Пожелания заказчика')->nullable();
            $table->string('doc_number', 255)->comment('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
        Schema::dropIfExists('commissions_users');
        Schema::dropIfExists('apz_provider_water_responses');
        Schema::dropIfExists('apz_provider_gas_responses');
        Schema::dropIfExists('apz_provider_heat_responses');
        Schema::dropIfExists('apz_provider_electricity_responses');
        Schema::dropIfExists('apz_provider_phone_responses');
    }
}