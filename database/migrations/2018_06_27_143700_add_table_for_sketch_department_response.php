<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableForSketchDepartmentResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sketch_apz_department_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sketch_id')->unsigned()->comment('ИД Эскизного проекта');
            $table->foreign('sketch_id')->references('id')->on('sketches')->onDelete('CASCADE');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('response_text', 255)->nullable()->comment('Ответ');
            $table->boolean('response')->comment('Флаг принятие');
            $table->timestamps();
        });

        DB::table('files_items_types')->insert([
            'name' => 'ТУ/МО отдел АПЗ (Эскизный проект)',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
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
