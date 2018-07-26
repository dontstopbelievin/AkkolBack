<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColTitleRuKzToVacancies extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('vacancies', function (Blueprint $table) {
      $table->renameColumn('title', 'title_ru');
      $table->text('title_kk')->comment('Название на казахском языке');
      $table->renameColumn('description', 'description_ru');
      $table->text('description_kk')->comment('Описание на казахском языке');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('vacancies', function (Blueprint $table) {
      if (Schema::hasColumn('vacancies', 'title_ru')) {
        $table->renameColumn('title_ru','title');
      }
      if (Schema::hasColumn('vacancies', 'title_kk')) {
        $table->dropColumn('title_kk');
      }
      if (Schema::hasColumn('vacancies', 'description_ru')) {
        $table->renameColumn('description_ru','description');
      }
      if (Schema::hasColumn('vacancies', 'description_kk')) {
        $table->dropColumn('description_kk');
      }
    });
  }
}
