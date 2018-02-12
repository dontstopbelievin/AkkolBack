<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Название');
            $table->string('description', 255)->comment('Описание')->nullable();
            $table->integer('level')->comment('Уровень')->defaultValue(1);
            $table->integer('parent_id')->unsigned()->comment('ИД родителя')->nullable();
            $table->foreign('parent_id')->references('id')->on('roles');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'name' => 'Temporary',
                'level' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Admin',
                'level' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Citizen',
                'level' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Urban',
                'level' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Provider',
                'level' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('roles')->insert([
            [
                'name' => 'Individual',
                'level' => 2,
                'parent_id' => 3,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Business',
                'level' => 2,
                'parent_id' => 3,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Head',
                'level' => 2,
                'parent_id' => 4,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Region',
                'level' => 2,
                'parent_id' => 4,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Engineer',
                'level' => 2,
                'parent_id' => 4,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Gas',
                'level' => 2,
                'parent_id' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Electricity',
                'level' => 2,
                'parent_id' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Water',
                'level' => 2,
                'parent_id' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Heat',
                'level' => 2,
                'parent_id' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Phone',
                'level' => 2,
                'parent_id' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('roles')->insert([
            [
                'name' => 'Алатау',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Алмалы',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Ауезов',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Бостандық',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Жетісу',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Медеу',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Наурызбай',
                'level' => 3,
                'parent_id' => 9,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Турксиб',
                'level' => 3,
                'parent_id' => 9,
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
        Schema::dropIfExists('roles');
    }
}
