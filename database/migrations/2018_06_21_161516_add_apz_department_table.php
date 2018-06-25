<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApzDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apz_apz_department_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs')->onDelete('CASCADE');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('doc_number')->nullable()->comment('Номер документа');
            $table->text('basis_for_development_apz')->nullable()->comment('Основание для разработки архитектурно-планировочного задания (АПЗ)');
            $table->text('building_presence')->nullable()->comment('Наличие застройки');
            $table->text('address')->nullable()->comment('Местонахождение участка');
            $table->text('geodetic_study')->nullable()->comment('Геодезическая изученность');
            $table->text('engineering_geological_study')->nullable()->comment('Инженерно-геологическая изученность');
            $table->text('planning_system')->nullable()->comment('Планировочная система');
            $table->text('functional_value_of_object')->nullable()->comment('Функциональное значение объекта');
            $table->text('floor_sum')->nullable()->comment('Этажность');
            $table->text('structural_scheme')->nullable()->comment('Конструктивная схема');
            $table->text('engineering_support')->nullable()->comment('Инженерное обеспечение');
            $table->text('energy_efficiency_class')->nullable()->comment('Класс энергоэффективности');
            $table->text('spatial_solution')->nullable()->comment('Объемно-пространственное решение');
            $table->text('draft_master_plan')->nullable()->comment('Проект генерального плана');
            $table->text('vertical_layout')->nullable()->comment('Вертикальная планировка');
            $table->text('landscaping_and_gardening')->nullable()->comment('Благоустройство и озеленение');
            $table->text('parking')->nullable()->comment('Парковка автомобилей');
            $table->text('use_of_fertile_soil_layer')->nullable()->comment('Использование плодородного слоя почвы');
            $table->text('small_architectural_forms')->nullable()->comment('Малые архитектурные формы');
            $table->text('lighting')->nullable()->comment('Освещение');
            $table->text('stylistics_of_architecture')->nullable()->comment('Стилистика архитектурного образа');
            $table->text('nature_combination')->nullable()->comment('Характер сочетания с окружающей застройкой');
            $table->text('color_solution')->nullable()->comment('Цветовое решение');
            $table->text('advertising_and_information_solution')->nullable()->comment('Рекламно-информационное решение');
            $table->text('night_lighting')->nullable()->comment('Ночное световое оформление');
            $table->text('input_nodes')->nullable()->comment('Входные узлы');
            $table->text('conditions_for_low_mobile_groups')->nullable()->comment('Создание условий для жизнедеятельности маломобильных групп населения');
            $table->text('compliance_noise_conditions')->nullable()->comment('Соблюдение условий по звукошумовым показателям');
            $table->text('plinth')->nullable()->comment('Цоколь');
            $table->text('facade')->nullable()->comment('Фасад. Ограждающие конструкций');
            $table->text('heat_supply')->nullable()->comment('Теплоснабжение');
            $table->text('water_supply')->nullable()->comment('Водоснабжение');
            $table->text('sewerage')->nullable()->comment('Канализация');
            $table->text('power_supply')->nullable()->comment('Электроснабжение');
            $table->text('gas_supply')->nullable()->comment('Газоснабжение');
            $table->text('phone_supply')->nullable()->comment('Телекоммуникация и телерадиовещания');
            $table->text('drainage')->nullable()->comment('Дренаж (при необходимости) и ливневая канализация');
            $table->text('irrigation_systems')->nullable()->comment('Стационарные поливочные системы');
            $table->text('engineering_surveys_obligation')->nullable()->comment('По инженерным изысканиям');
            $table->text('demolition_obligation')->nullable()->comment('По сносу (переносу) существующих строений и сооружений');
            $table->text('transfer_communications_obligation')->nullable()->comment('По переносу существующих подземных и надземных коммуникаций');
            $table->text('conservation_plant_obligation')->nullable()->comment('По сохранению и/или пересадке зеленых насаждений');
            $table->text('temporary_fencing_construction_obligation')->nullable()->comment('По строительству временного ограждения участка');
            $table->text('additional_requirements')->nullable()->comment('Дополнительные требования');
            $table->text('general_requirements')->nullable()->comment('Общие требования');
            $table->text('notes')->nullable()->comment('Примечания');
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
        //
    }
}
