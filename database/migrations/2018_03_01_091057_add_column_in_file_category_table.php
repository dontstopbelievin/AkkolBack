<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInFileCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files_categories', function (Blueprint $table) {
            $table->integer('role_id')->nullable()->after('is_visible')->unsigned()->comment('ИД роли');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        DB::table('files_categories')->where(['name_ru' => 'Бюджетное планирование'])->update(['is_visible' => 1, 'role_id' => \App\Role::ADMIN]);
        DB::table('files_categories')->where(['name_ru' => 'Инструкция пользователя'])->update(['is_visible' => 1, 'role_id' => \App\Role::ADMIN]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files_categories', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });

        DB::table('files_categories')->where(['name_ru' => 'Бюджетное планирование'])->update(['is_visible' => 0, 'role_id' => null]);
        DB::table('files_categories')->where(['name_ru' => 'Инструкция пользователя'])->update(['is_visible' => 0, 'role_id' => null]);
    }
}
