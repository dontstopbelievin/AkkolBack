<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Apz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apz_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Название');
            $table->timestamps();
        });

        DB::table('apz_statuses')->insert([
            [
                'name' => 'Отказано',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Принято',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Архитектор',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Провайдер',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Главный архитектор',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
        ]);

        Schema::create('apzs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('region', 255)->comment('Район')->nullable();
            $table->string('project_type', 255)->comment('Тип проекта')->nullable();
            $table->string('applicant', 255)->comment('Наименование заявителя')->nullable();
            $table->string('address', 255)->comment('Адрес')->nullable();
            $table->string('phone', 255)->comment('Телефон')->nullable();
            $table->string('customer', 255)->comment('Заказчик')->nullable();
            $table->string('designer', 255)->comment('Проектировщик №ГСЛ, категория')->nullable();
            $table->string('object_type', 255)->comment('Тип объекта')->nullable();
            $table->string('object_level', 255)->comment('Этажность')->nullable();
            $table->string('object_client', 255)->comment('Заказчик');
            $table->string('object_area', 255)->comment('Площадь здания (кв.м)')->nullable();
            $table->string('object_rooms', 255)->comment('Количество квартир (номеров, кабинетов)')->nullable();
            $table->string('object_term', 255)->comment('Срок строительства по нормам')->nullable();
            $table->string('project_name', 255)->comment('Наименование проектируемого объекта')->nullable();
            $table->string('project_address', 255)->comment('Адрес проектируемого объекта')->nullable();
            $table->string('project_address_coordinates', 255)->comment('Координаты проектируемого объекта')->nullable();
            $table->string('cadastral_number', 255)->comment('Кадастровый номер')->nullable();
            $table->integer('status_id')->unsigned()->comment('ИД статуса')->nullable();
            $table->foreign('status_id')->references('id')->on('apz_statuses');
            $table->timestamps();
        });

        Schema::create('apz_waters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->float('requirement', 11,3)->comment('Общая потребность в воде');
            $table->float('drinking', 11,3)->comment('На хозпитьевые нужды')->nullable();
            $table->float('production', 11,3)->comment('На производственные нужды')->nullable();
            $table->float('fire_fighting', 11,3)->comment('Потребные расходы наружного пожаротушения')->nullable();
            $table->float('sewage', 11,3)->comment('Канализация');
            $table->integer('status')->default(2)->comment('Статус (0-declined, 1-accepted, 2-active)');
            $table->timestamps();
        });

        Schema::create('apz_heats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs')->nullable();
            $table->float('general', 11,3)->comment('Общая тепловая нагрузка')->nullable();
            $table->float('main', 11,3)->comment('Отопление')->nullable();
            $table->float('ventilation', 11,3)->comment('Вентиляция')->nullable();
            $table->float('water', 11,3)->comment('Горячее водоснабжение')->nullable();
            $table->float('tech', 11,3)->comment('Технологические нужды')->nullable();
            $table->string('distribution', 255)->comment('Разделить нагрузку по жилью и по встроенным помещениям')->nullable();
            $table->string('saving', 255)->comment('Энергосберегающее мероприятие')->nullable();
            $table->integer('status')->default(2)->comment('Статус (0-declined, 1-accepted, 2-active)');
            $table->timestamps();
        });

        Schema::create('apz_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->float('service_num', 11,3)->comment('Количество ОТА и услуг в разбивке физ.лиц и юр.лиц')->nullable();
            $table->string('capacity', 255)->comment('Телефонная емкость')->nullable();
            $table->string('sewage', 255)->comment('Планируемая телефонная канализация')->nullable();
            $table->string('client_wishes', 255)->comment('Пожелания заказчика')->nullable();
            $table->integer('status')->default(2)->comment('Статус (0-declined, 1-accepted, 2-active)');
            $table->timestamps();
        });

        Schema::create('apz_electricity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->float('required_power', 11,3)->comment('Требуемая мощность');
            $table->string('phase', 255)->comment('Характер нагрузки')->nullable();
            $table->string('safety_category', 255)->comment('Категория по надежности')->nullable();
            $table->float('max_load_device', 11,3)->comment('Из указанной макс. нагрузки относятся к электроприемникам')->nullable();
            $table->float('max_load', 11,3)->comment('Существующая максимальная нагрузка')->nullable();
            $table->float('allowed_power', 11,3)->comment('Мощность трансформаторов')->nullable();
            $table->integer('status')->default(2)->comment('Статус (0-declined, 1-accepted, 2-active)');
            $table->timestamps();
        });

        Schema::create('apz_gases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->float('general', 11,3)->comment('Общая потребность');
            $table->float('cooking', 11,3)->comment('На приготовление пищи')->nullable();
            $table->float('heat', 11,3)->comment('Отопление');
            $table->float('ventilation', 11,3)->comment('Вентиляция')->nullable();
            $table->float('conditionaer', 11,3)->comment('Кондиционирование')->nullable();
            $table->float('water', 11,3)->comment('Горячее водоснабжение')->nullable();
            $table->integer('status')->default(2)->comment('Статус (0-declined, 1-accepted, 2-active)');
            $table->timestamps();
        });

        Schema::create('apz_sewages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
            $table->float('amount', 11,3)->comment('Общее количество сточных вод');
            $table->float('feksal', 11,3)->comment('Фекcальных')->nullable();
            $table->float('production', 11,3)->comment('Производственно-загрязненных')->nullable();
            $table->float('to_city', 11,3)->comment('Условно-чистых сбрасываемых на городскую канализацию')->nullable();
            $table->string('client_wishes', 255)->comment('Пожелание заказчика')->nullable();
            $table->integer('status')->default(2)->comment('Статус (0-declined, 1-accepted, 2-active)');
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
        Schema::dropIfExists('apzs');
        Schema::dropIfExists('apz_statuses');
        Schema::dropIfExists('apz_waters');
        Schema::dropIfExists('apz_heats');
        Schema::dropIfExists('apz_phones');
        Schema::dropIfExists('apz_electricity');
        Schema::dropIfExists('apz_gases');
        Schema::dropIfExists('apz_sewages');
    }
}
