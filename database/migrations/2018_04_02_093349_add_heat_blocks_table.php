<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeatBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apz_heats_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs')->onDelete('CASCADE');
            $table->float('main', 11,4)->nullable()->comment('Отопление');
            $table->float('ventilation', 11,4)->nullable()->comment('Вентиляция');
            $table->float('water', 11,4)->nullable()->comment('Горячее водоснабжение (ср/ч)');
            $table->float('water_max', 11,4)->nullable()->comment('Горячее водоснабжение (макс/ч)');
            $table->timestamps();
        });

        Schema::create('apz_provider_heat_block_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('block_id')->unsigned()->comment('ИД блока');
            $table->foreign('block_id')->references('id')->on('apz_heats_blocks');
            $table->integer('response_id')->unsigned()->comment('ИД ответа');
            $table->foreign('response_id')->references('id')->on('apz_provider_heat_responses')->onDelete('CASCADE');
            $table->float('main_in_contract', 11,4)->nullable()->comment('Отопление');
            $table->float('ven_in_contract', 11,4)->nullable()->comment('Вентиляция');
            $table->float('water_in_contract', 11,4)->nullable()->comment('Горячее водоснабжение (ср/ч)');
            $table->float('water_in_contract_max', 11,4)->nullable()->comment('Горячее водоснабжение (макс/ч)');
            $table->timestamps();
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->dropColumn(['main_in_contract', 'ven_in_contract', 'water_in_contract', 'water_in_contract_max']);
        });

        Schema::table('apz_heats', function (Blueprint $table) {
            $table->dropColumn(['main', 'ventilation', 'water', 'water_max']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apz_heats_blocks');

        Schema::table('apz_heats', function (Blueprint $table) {
            $table->float('main', 11,4)->after('general')->nullable()->comment('Отопление');
            $table->float('ventilation', 11,4)->after('main')->nullable()->comment('Вентиляция');
            $table->float('water', 11,4)->after('ventilation')->nullable()->comment('Горячее водоснабжение (ср/ч)');
            $table->float('water_max', 11,4)->after('water')->nullable()->comment('Горячее водоснабжение (макс/ч)');
        });
    }
}
