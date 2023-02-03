<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciationSeeder extends Seeder
{
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
