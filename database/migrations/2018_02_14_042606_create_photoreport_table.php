<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoreportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photoreports_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Название');
            $table->timestamps();
        });

        Schema::create('photoreports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_name')->comment('Наименование компании');
            $table->integer('company_legal_address')->comment('Юридический адрес компании');
            $table->integer('company_factual_address')->comment('Дата заявки');
            $table->integer('photo_address')->comment('Адрес рекламы');
            $table->integer('company_region')->comment('Регион компании');
            $table->integer('iin')->comment('ИИН');
            $table->integer('company_phone')->comment('Телефон компании');
            $table->integer('start_date')->comment('Период с');
            $table->integer('end_date')->comment('Период до');
            $table->integer('status_id')->unsigned()->default(3)->comment('Статус')->nullable();
            $table->foreign('status_id')->references('id')->on('photoreports_statuses');
            $table->integer('comments')->comment('Комментарий');
            $table->integer('user_id')->unsigned()->comment('Заявитель')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        DB::table('photoreports_statuses')->insert([
            [
                'name' => 'Отклонено',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Одобрено',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'В процессе',
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
        Schema::dropIfExists('photoreports');
    }
}
