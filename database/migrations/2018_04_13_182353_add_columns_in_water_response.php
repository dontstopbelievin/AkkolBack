<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInWaterResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->float('estimated_water_flow_rate', 11, 3)->after('recommendation')->nullable()->comment('Расчетный расход воды');
            $table->float('existing_water_consumption', 11, 3)->after('estimated_water_flow_rate')->nullable()->comment('Существующий расход воды');
            $table->float('sewage_estimated_water_flow_rate', 11, 3)->after('existing_water_consumption')->nullable()->comment('Расчетный расход воды (Водоотведение)');
            $table->float('sewage_existing_water_consumption', 11, 3)->after('sewage_estimated_water_flow_rate')->nullable()->comment('Существующий расход воды (Водоотведение)');
            $table->float('water_pressure', 11, 3)->after('sewage_existing_water_consumption')->nullable()->comment('Давление в сети городского водопровода в точке подключения');
            $table->text('water_customer_duties')->after('water_pressure')->nullable()->comment('Обязанности заказчика');
            $table->text('sewage_customer_duties')->after('water_customer_duties')->nullable()->comment('Обязанности заказчика (Водоотведение)');
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
