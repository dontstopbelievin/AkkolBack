<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInWaterProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->text('tc_text_water')->nullable()->after('sewage_customer_duties')->comment('Текст для поле "Водопотребление" (Водопотребление)');
            $table->text('tc_text_water_requirements')->nullable()->after('tc_text_water')->comment('Текст для поле "Другие требования" (Водопотребление)');
            $table->text('tc_text_water_general')->nullable()->after('tc_text_water_requirements')->comment('Текст для поле "Общие положения" (Водопотребление)');
            $table->text('tc_text_sewage')->nullable()->after('tc_text_water_general')->comment('Текст для поле "Водоотведение" (Водоотведение)');
            $table->text('tc_text_sewage_requirements')->nullable()->after('tc_text_sewage')->comment('Текст для поле "Другие требования" (Водоотведение)');
            $table->text('tc_text_sewage_general')->nullable()->after('tc_text_sewage_requirements')->comment('Текст для поле "Общие положения" (Водоотведение)');
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
