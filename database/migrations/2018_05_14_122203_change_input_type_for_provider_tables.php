<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInputTypeForProviderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_electricity_responses', function (Blueprint $table) {
            $table->text('response_text')->nullable()->comment('Ответ')->change();
            $table->text('comments')->nullable()->comment('Комментарий')->change();
        });

        Schema::table('apz_provider_gas_responses', function (Blueprint $table) {
            $table->text('response_text')->nullable()->comment('Ответ')->change();
            $table->text('comments')->nullable()->comment('Комментарий')->change();
        });

        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->text('response_text')->nullable()->comment('Ответ')->change();
            $table->text('comments')->nullable()->comment('Комментарий')->change();
            $table->text('connection_scheme')->nullable()->comment('Схема подключения')->change();
            $table->text('addition')->nullable()->comment('Дополнительное')->change();
        });

        Schema::table('apz_provider_phone_responses', function (Blueprint $table) {
            $table->text('response_text')->nullable()->comment('Ответ')->change();
            $table->text('comments')->nullable()->comment('Комментарий')->change();
        });

        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->text('response_text')->nullable()->comment('Ответ')->change();
            $table->text('comments')->nullable()->comment('Комментарий')->change();
        });

        Schema::table('apz_states_history', function (Blueprint $table) {
            $table->text('comment')->nullable()->comment('Комментарий')->change();
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
