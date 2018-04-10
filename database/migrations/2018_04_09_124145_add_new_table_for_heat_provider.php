<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableForHeatProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->string('second_resource', 255)->nullable()->after('resource')->comment('Второй источник');
            $table->string('two_pipe_tc_name', 255)->nullable()->after('transporter')->comment('Название 2-трубной ТК');
            $table->string('heat_four_pipe_sc_name', 255)->nullable()->after('two_pipe_pressure_in_rc')->comment('Название 4-трубной СК');
            $table->string('heat_four_pipe_tc_name', 255)->nullable()->after('two_pipe_pressure_in_rc')->comment('Название 4-трубной ТК');
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->dropColumn('trans_pressure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->dropColumn(['second_resource', 'two_pipe_tc_name', 'heat_four_pipe_tc_name', 'heat_four_pipe_sc_name']);
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->string('trans_pressure', 255)->nullable()->after('name')->comment('Давление теплоносителя в тепловой камере');
        });
    }
}
