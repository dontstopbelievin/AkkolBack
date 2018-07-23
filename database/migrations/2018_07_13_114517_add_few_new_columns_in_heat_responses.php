<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFewNewColumnsInHeatResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->text('energy_efficiency')->nullable()->after('final_heat_loads')->comment('Энергоэффективность');
            $table->string('contract_num', 255)->nullable()->after('water_in_contract_max')->comment('Номер договора');
            $table->double('main_increase', 11, 4)->nullable()->after('addition')->comment('Прирост (отопление)');
            $table->double('main_percentage_increase', 11, 2)->nullable()->after('main_increase')->comment('Прирост в процентах (отопление)');
            $table->double('ven_increase', 11, 4)->nullable()->after('main_percentage_increase')->comment('Прирост (вентиляция)');
            $table->double('ven_percentage_increase', 11, 2)->nullable()->after('ven_increase')->comment('Прирост в процентах (вентиляция)');
            $table->double('water_max_increase', 11, 4)->nullable()->after('ven_percentage_increase')->comment('Прирост (ГВС макс/ч)');
            $table->double('water_max_percentage_increase', 11, 2)->nullable()->after('water_max_increase')->comment('Прирост в процентах (ГВС макс/ч)');
            $table->double('final_increase', 11, 4)->nullable()->after('water_max_percentage_increase')->comment('Итоговый прирост');
            $table->double('final_percentage_increase', 11, 2)->nullable()->after('final_increase')->comment('Итоговый прирост в процентах');
        });

        Schema::table('apz_heats', function (Blueprint $table) {
            $table->string('contract_num', 255)->nullable()->after('saving')->comment('Номер договора');
            $table->double('main_in_contract', 11, 4)->nullable()->after('contract_num')->comment('Отопление по договору');
            $table->double('ven_in_contract', 11, 4)->nullable()->after('main_in_contract')->comment('Вентиляция по договору');
            $table->double('water_in_contract', 11, 4)->nullable()->after('ven_in_contract')->comment('Горячее водоснабжение по договору (ср/ч)	');
            $table->double('water_in_contract_max', 11, 4)->nullable()->after('water_in_contract')->comment('Горячее водоснабжение по договору (макс/ч)');
        });

        DB::table('apz_states')->insert([
            [
                'code' => 'water_signed',
                'name' => 'Подписан провайдером водоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'gas_signed',
                'name' => 'Подписан провайдером Газоснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'electricity_signed',
                'name' => 'Подписан провайдером электроснабжение',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'phone_signed',
                'name' => 'Подписан провайдером телефонизация',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'code' => 'heat_signed',
                'name' => 'Подписан провайдером теплоснабжение',
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
