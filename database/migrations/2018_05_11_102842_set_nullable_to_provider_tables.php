<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableToProviderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_electricity_responses', function (Blueprint $table) {
            $table->string('doc_number', 255)->nullable()->comment('Номер документа')->change();
        });

        Schema::table('apz_provider_gas_responses', function (Blueprint $table) {
            $table->string('doc_number', 255)->nullable()->comment('Номер документа')->change();
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->string('doc_number', 255)->nullable()->comment('Номер документа')->change();
        });

        Schema::table('apz_provider_phone_responses', function (Blueprint $table) {
            $table->string('doc_number', 255)->nullable()->comment('Номер документа')->change();
        });

        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->string('doc_number', 255)->nullable()->comment('Номер документа')->change();
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
