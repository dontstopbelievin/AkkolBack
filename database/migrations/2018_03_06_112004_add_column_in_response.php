<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_electricity_responses', function (Blueprint $table) {
            $table->integer('apz_id')->nullable()->after('commission_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
        });

        Schema::table('apz_provider_gas_responses', function (Blueprint $table) {
            $table->integer('apz_id')->nullable()->after('commission_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->integer('apz_id')->nullable()->after('commission_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
        });

        Schema::table('apz_provider_phone_responses', function (Blueprint $table) {
            $table->integer('apz_id')->nullable()->after('commission_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
        });

        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->integer('apz_id')->nullable()->after('commission_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apz_provider_electricity_responses', function (Blueprint $table) {
            $table->dropColumn('apz_id');
        });

        Schema::table('apz_provider_gas_responses', function (Blueprint $table) {
            $table->dropColumn('apz_id');
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->dropColumn('apz_id');
        });

        Schema::table('apz_provider_phone_responses', function (Blueprint $table) {
            $table->dropColumn('apz_id');
        });

        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->dropColumn('apz_id');
        });
    }
}
