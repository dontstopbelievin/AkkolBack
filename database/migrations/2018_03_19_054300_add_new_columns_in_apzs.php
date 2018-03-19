<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInApzs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_waters', function (Blueprint $table) {
            $table->float('requirement', 11,3)->nullable()->comment('Общая потребность (м3/сутки)')->change();
            $table->float('requirement_hour', 11,3)->nullable()->after('requirement')->comment('Общая потребность (м3/час питьевой воды)');
            $table->float('requirement_sec', 11,3)->nullable()->after('requirement_hour')->comment('Общая потребность (л/сек макс)');

            $table->float('drinking', 11,3)->nullable()->comment('Хозпитьевые нужды (м3/сутки)')->change();
            $table->float('drinking_hour', 11,3)->nullable()->after('drinking')->comment('Хозпитьевые нужды (м3/час)');
            $table->float('drinking_sec', 11,3)->nullable()->after('drinking_hour')->comment('Хозпитьевые нужды (л/сек макс)');

            $table->float('production', 11,3)->nullable()->comment('Производственные нужды (м3/сутки)')->change();
            $table->float('production_hour', 11,3)->nullable()->after('production')->comment('Производственные нужды (м3/час)');
            $table->float('production_sec', 11,3)->nullable()->after('production_hour')->comment('Производственные нужды (л/сек макс)');
        });

        Schema::table('apz_sewages', function (Blueprint $table) {
            $table->float('amount', 11,3)->nullable()->comment('Общее количество сточных вод (м3/сутки)')->change();
            $table->float('amount_hour', 11,3)->nullable()->after('amount')->comment('Общее количество сточных вод (м3/час макс)');

            $table->float('feksal', 11,3)->nullable()->comment('Фекальных (м3/сутки)')->change();
            $table->float('feksal_hour', 11,3)->nullable()->after('feksal')->comment('Фекальных (м3/час макс)');

            $table->float('production', 11,3)->nullable()->comment('Производственно-загрязненных (м3/сутки)')->change();
            $table->float('production_hour', 11,3)->nullable()->after('production')->comment('Производственно-загрязненных (м3/час макс)');

            $table->float('to_city', 11,3)->nullable()->comment('Условно-чистых сбрасываемых на городскую сеть (м3/сутки)')->change();
            $table->float('to_city_hour', 11,3)->nullable()->after('to_city')->comment('Условно-чистых сбрасываемых на городскую сеть (м3/час макс)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apz_waters', function (Blueprint $table) {
            $table->dropColumn('requirement_hour');
            $table->dropColumn('requirement_sec');
            $table->dropColumn('drinking_hour');
            $table->dropColumn('drinking_sec');
            $table->dropColumn('production_hour');
            $table->dropColumn('production_sec');
        });

        Schema::table('apz_sewages', function (Blueprint $table) {
            $table->dropColumn('amount_hour');
            $table->dropColumn('feksal_hour');
            $table->dropColumn('production_hour');
            $table->dropColumn('to_city_hour');
        });
    }
}
