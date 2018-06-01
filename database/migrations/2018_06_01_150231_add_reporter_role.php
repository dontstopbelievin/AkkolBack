<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReporterRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
           [
               'name' => 'Reporter',
               'description' => 'Пользователь для добавления новостей в сайте',
               'level' => 1,
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now()
           ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->where('name','=','Reporter')->delete();
    }
}
