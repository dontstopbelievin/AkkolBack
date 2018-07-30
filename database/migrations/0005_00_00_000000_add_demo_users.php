<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDemoUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            [
                'name' => 'citizen',
                'email' => 'citizen@payda.kz',
                'first_name' => 'citizen',
                'last_name' => 'citizen',
                'middle_name' => 'citizen',
                'iin' => 'citizen',
                'bin' => 'citizen',
                'password' => Hash::make('passcitizen'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'urban',
                'email' => 'urban@payda.kz',
                'first_name' => 'urban',
                'last_name' => 'urban',
                'middle_name' => 'urban',
                'iin' => 'urban',
                'bin' => 'urban',
                'password' => Hash::make('passurban'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'engineer',
                'email' => 'engineer@payda.kz',
                'first_name' => 'engineer',
                'last_name' => 'engineer',
                'middle_name' => 'engineer',
                'iin' => 'engineer',
                'bin' => 'engineer',
                'password' => Hash::make('passengineer'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'water',
                'email' => 'water@payda.kz',
                'first_name' => 'water',
                'last_name' => 'water',
                'middle_name' => 'water',
                'iin' => 'water',
                'bin' => 'water',
                'password' => Hash::make('passwater'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'gas',
                'email' => 'gas@payda.kz',
                'first_name' => 'gas',
                'last_name' => 'gas',
                'middle_name' => 'gas',
                'iin' => 'gas',
                'bin' => 'gas',
                'password' => Hash::make('passgas'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'electro',
                'email' => 'electro@payda.kz',
                'first_name' => 'electro',
                'last_name' => 'electro',
                'middle_name' => 'electro',
                'iin' => 'electro',
                'bin' => 'electro',
                'password' => Hash::make('passelectro'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'phone',
                'email' => 'phone@payda.kz',
                'first_name' => 'phone',
                'last_name' => 'phone',
                'middle_name' => 'phone',
                'iin' => 'phone',
                'bin' => 'phone',
                'password' => Hash::make('passphone'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'heat',
                'email' => 'heat@payda.kz',
                'first_name' => 'heat',
                'last_name' => 'heat',
                'middle_name' => 'heat',
                'iin' => 'heat',
                'bin' => 'heat',
                'password' => Hash::make('passheat'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'apz',
                'email' => 'apz@payda.kz',
                'first_name' => 'apz',
                'last_name' => 'apz',
                'middle_name' => 'apz',
                'iin' => 'apz',
                'bin' => 'apz',
                'password' => Hash::make('passapz'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'head',
                'email' => 'head@payda.kz',
                'first_name' => 'head',
                'last_name' => 'head',
                'middle_name' => 'head',
                'iin' => 'head',
                'bin' => 'head',
                'password' => Hash::make('passhead'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
        ]);

        DB::table('role_user')->insert([
            [
                'role_id' => 3, // citizen
                'user_id' => 1  // citizen
            ],
            [
                'role_id' => 6, // individual
                'user_id' => 1  // citizen
            ],
            [
                'role_id' => 4, // urban
                'user_id' => 2  // urban
            ],
            [
                'role_id' => 9, // region
                'user_id' => 2  // urban
            ],
            [
                'role_id' => 22, // наурызбай
                'user_id' => 2   // urban
            ],
            [
                'role_id' => 4, // urban
                'user_id' => 3  // engineer
            ],
            [
                'role_id' => 10, // engineer
                'user_id' => 3   // engineer
            ],
            [
                'role_id' => 5, // provider
                'user_id' => 4  // water
            ],
            [
                'role_id' => 13, // water
                'user_id' => 4   // water
            ],
            [
                'role_id' => 5, // provider
                'user_id' => 5  // gas
            ],
            [
                'role_id' => 11, // gas
                'user_id' => 5   // gas
            ],
            [
                'role_id' => 5, // provider
                'user_id' => 6  // electricity
            ],
            [
                'role_id' => 12, // electricity
                'user_id' => 6   // electricity
            ],
            [
                'role_id' => 5, // provider
                'user_id' => 7  // phone
            ],
            [
                'role_id' => 15, // phone
                'user_id' => 7   // phone
            ],
            [
                'role_id' => 5, // provider
                'user_id' => 8  // heat
            ],
            [
                'role_id' => 14, // heat
                'user_id' => 8   // heat
            ],
            [
                'role_id' => 25, // apzDepartment
                'user_id' => 9   // apzDepartment
            ],
            [
                'role_id' => 4, // urban
                'user_id' => 10 // head
            ],
            [
                'role_id' => 8, // head
                'user_id' => 10 // head
            ],
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
