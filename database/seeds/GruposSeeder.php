<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupos = ['Tecnología','Cocina','Agricultura y Ganadería', 'Estudios','Medicina','Religión','Lexachange','Otro'];
        foreach($grupos as $grupo)DB::table('grupos')->insert(['grupo' => $grupo]);
    }
}
