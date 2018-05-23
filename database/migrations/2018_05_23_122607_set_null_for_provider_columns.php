<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullForProviderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_water_responses', function (Blueprint $table) {
            $table->float('gen_water_req', 11, 3)->nullable()->comment('Общая потребность в воде')->change();
            $table->float('drinking_water', 11, 3)->nullable()->comment('На хозпитьевые нужды')->change();
            $table->float('prod_water', 11, 3)->nullable()->comment('На производственные нужды')->change();
            $table->float('fire_fighting_water_in', 11, 3)->nullable()->comment('Потребные расходы внутреннего пожаротушения')->change();
            $table->float('fire_fighting_water_out', 11, 3)->nullable()->comment('Потребные расходы наружного пожаротушения')->change();
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
