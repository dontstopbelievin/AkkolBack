<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnInHeatResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->dropColumn('after_control_unit_installation');
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
            $table->text('after_control_unit_installation')->nullable()->comment('По завершении монтажа узла управления');
        });
    }
}
