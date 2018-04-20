<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullForApzColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_gases', function (Blueprint $table) {
            $table->float('general', 11, 3)->nullable()->comment('Общая потребность')->change();
            $table->float('heat', 11, 3)->nullable()->comment('Отопление')->change();
        });

        Schema::table('apz_waters', function (Blueprint $table) {
            $table->float('sewage', 11, 3)->nullable()->comment('Канализация')->change();
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
