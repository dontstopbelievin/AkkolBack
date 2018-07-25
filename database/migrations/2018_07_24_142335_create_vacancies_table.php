<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacanciesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('vacancies', function (Blueprint $table) {
      $table->increments('id');
      $table->text('title')->comment('Заголовок записи вакансии');
      $table->text('description')->comment('Описание записи вакансии');
      $table->text('content_kk')->comment('Контент вакансии на казахском');
      $table->text('content_ru')->comment('Контент вакансии на русском');
      $table->integer('status')->comment('1-активный, 2-отключенный');
      $table->timestamps();
      $table->SoftDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('vacancies');
  }
}
