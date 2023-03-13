<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //inserta al departamento de sistemas
        DB::table('departments')->insert([
            'name' => 'TI'
        ]);
        //inserta los tipos de usuarios
        DB::table('users_type')->insert(['type' => 'Administrador']);
        DB::table('users_type')->insert(['type' => 'Usuario']);

        //inserta al usuario administrador a la base de datos
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'practicante2@agnieto.com',
            'department'=> 1,
            'password' => Hash::make('1380JpLm'),
            'type' => 1
        ]);

    }
}