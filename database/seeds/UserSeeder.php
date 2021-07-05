<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nombre_apellido' => 'Papper',
            'email' => 'andres03marquez@gmail.com',
            'password' => bcrypt('Andres.28518939')
        ]);
        DB::table('users')->insert([
            'nombre_apellido' => 'Andres Marquez',
            'email' => 'andres03ruht@gmail.com',
            'password' => bcrypt('Andres.28518939')
        ]);
    }
}
