<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeApzColums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apzs', function (Blueprint $table) {
            $table->string('object_client', 255)->nullable()->comment('Заказчик')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apzs', function (Blueprint $table) {
            $table->string('object_client', 255)->comment('Заказчик')->change();
        });
    }
}
