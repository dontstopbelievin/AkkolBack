<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSketchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sketch_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Название');
            $table->timestamps();
        });

        DB::table('sketch_statuses')->insert([
            [
                'name' => 'Отказано',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Принято',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'В процессе',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);


        Schema::create('sketches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('applicant', 255)->nullable()->comment('Заявитель');
            $table->string('customer', 255)->nullable()->comment('Заказчик');
            $table->string('address', 255)->nullable()->comment('Адрес');
            $table->string('designer', 255)->nullable()->comment('Проектировщик');
            $table->string('phone', 255)->nullable()->comment('Телефон');
            $table->string('project_name', 255)->nullable()->comment('Наименование проектируемого объекта');
            $table->string('project_address', 255)->nullable()->comment('Адрес проектируемого объекта');
            $table->dateTime('sketchDate')->nullable()->comment('Дата');

            $table->integer('reviewer_id')->unsigned()->comment('ИД пользователя')->nullable();
            $table->foreign('reviewer_id')->references('id')->on('users');

            $table->integer('user_id')->unsigned()->comment('ИД пользователя');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('status_id')->unsigned()->comment('ИД статуса');
            $table->foreign('status_id')->references('id')->on('sketch_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sketches');
        Schema::dropIfExists('sketch_statuses');
    }
}
