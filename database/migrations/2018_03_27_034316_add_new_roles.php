<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commissions_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::create('apz_provider_heads_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apz_id')->unsigned()->comment('ИД АПЗ');
            $table->foreign('apz_id')->references('id')->on('apzs')->onDelete('CASCADE');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('role_id')->unsigned()->comment('ИД роли')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('comments', 255)->comment('Комментарий')->nullable();
            $table->boolean('is_accepted')->default(true)->comment('Флаг принятие');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'name' => 'PerformerGas',
                'description' => 'Исполнитель',
                'level' => '3',
                'parent_id' => \App\Role::GAS,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'HeadGas',
                'description' => 'Начальник отдела газоснабжения',
                'level' => '3',
                'parent_id' => \App\Role::GAS,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'DirectorGas',
                'description' => 'Директор',
                'level' => '3',
                'parent_id' => \App\Role::GAS,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'PerformerWater',
                'description' => 'Исполнитель',
                'level' => '3',
                'parent_id' => \App\Role::WATER,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'HeadWater',
                'description' => 'Начальник отдела водоснабжения',
                'level' => '3',
                'parent_id' => \App\Role::WATER,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'DirectorWater',
                'description' => 'Директор',
                'level' => '3',
                'parent_id' => \App\Role::WATER,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'PerformerHeat',
                'description' => 'Исполнитель',
                'level' => '3',
                'parent_id' => \App\Role::HEAT,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'HeadHeat',
                'description' => 'Начальник отдела теплоснабжения',
                'level' => '3',
                'parent_id' => \App\Role::HEAT,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'DirectorHeat',
                'description' => 'Директор',
                'level' => '3',
                'parent_id' => \App\Role::HEAT,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'PerformerPhone',
                'description' => 'Исполнитель',
                'level' => '3',
                'parent_id' => \App\Role::PHONE,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'HeadPhone',
                'description' => 'Начальник отдела телефонизации',
                'level' => '3',
                'parent_id' => \App\Role::PHONE,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'DirectorPhone',
                'description' => 'Директор',
                'level' => '3',
                'parent_id' => \App\Role::PHONE,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'PerformerElectricity',
                'description' => 'Исполнитель',
                'level' => '3',
                'parent_id' => \App\Role::ELECTRICITY,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'HeadElectricity',
                'description' => 'Начальник отдела электроснабжения',
                'level' => '3',
                'parent_id' => \App\Role::ELECTRICITY,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'DirectorElectricity',
                'description' => 'Директор',
                'level' => '3',
                'parent_id' => \App\Role::ELECTRICITY,
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
        //
    }
}
