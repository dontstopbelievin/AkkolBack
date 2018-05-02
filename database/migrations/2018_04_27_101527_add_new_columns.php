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
        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->float('fire_fighting_in', 11, 3)->after('fire_fighting')->nullable()->comment('Потребные расходы внутреннего пожаротушения (л/сек)');
            $table->integer('people_count')->after('fire_fighting')->nullable()->comment('Количество людей');
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
