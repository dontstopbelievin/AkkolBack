<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInHeatResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->float('main_in_contract', 11,4)->nullable()->after('water_four_pipe_pressure_in_rc')->comment('Отопление по договору');
            $table->float('ven_in_contract', 11,4)->nullable()->after('main_in_contract')->comment('Вентиляция по договору');
            $table->float('water_in_contract', 11,4)->nullable()->after('ven_in_contract')->comment('Горячее водоснабжение по договору (ср/ч)');
            $table->float('water_in_contract_max', 11,4)->nullable()->after('water_in_contract')->comment('Горячее водоснабжение по договору (макс/ч)');
        });

        Schema::table('apz_provider_heat_block_responses', function (Blueprint $table) {
            $table->dropColumn(['main_in_contract', 'ven_in_contract', 'water_in_contract', 'water_in_contract_max']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
