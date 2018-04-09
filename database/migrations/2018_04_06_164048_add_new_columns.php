<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_heat_block_responses', function (Blueprint $table) {
            $table->float('main', 11,4)->nullable()->after('response_id')->comment('Отопление');
            $table->float('ven', 11,4)->nullable()->after('main')->comment('Вентиляция');
            $table->float('water', 11,4)->nullable()->after('ven')->comment('Горячее водоснабжение (ср/ч)	');
            $table->float('water_max', 11,4)->nullable()->after('water')->comment('Горячее водоснабжение (макс/ч)');
            $table->float('main_in_contract', 11,4)->nullable()->comment('Отопление по договору')->change();
            $table->float('ven_in_contract', 11,4)->nullable()->comment('Вентиляция по договору')->change();
            $table->float('water_in_contract', 11,4)->nullable()->comment('Горячее водоснабжение по договору (ср/ч)')->change();
            $table->float('water_in_contract_max', 11,4)->nullable()->comment('Горячее водоснабжение по договору (макс/ч)')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apz_provider_heat_block_responses', function (Blueprint $table) {
            $table->dropColumn(['main', 'ven', 'water', 'water_max']);
            $table->float('main_in_contract', 11,4)->nullable()->comment('Отопление')->change();
            $table->float('ven_in_contract', 11,4)->nullable()->comment('Вентиляция')->change();
            $table->float('water_in_contract', 11,4)->nullable()->comment('Горячее водоснабжение (ср/ч)')->change();
            $table->float('water_in_contract_max', 11,4)->nullable()->comment('Горячее водоснабжение (макс/ч)')->change();
        });
    }
}
