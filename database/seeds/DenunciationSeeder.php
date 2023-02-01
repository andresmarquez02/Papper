<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denunciations')->insert([
            ['denunciation' => 'Publicacion Racista'],
            ['denunciation' => 'Fuera de lugar'],
            ['denunciation' => 'Contenido obseno'],
            ['denunciation' => 'Pregunta mas formulada'],
            ['denunciation' => 'Pregunta muy idiota'],
        ]);
    }
}
