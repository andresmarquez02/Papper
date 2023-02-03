<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{

    public function run()
    {
        $category = [
            ['category' => 'Tecnología'],
            ['category' => 'Cocina'],
            ['category' => 'Agricultura y Ganadería'],
            ['category' => 'Estudios'],
            ['category' => 'Medicina'],
            ['category' => 'Religión'],
            ['category' => 'Lexachange'],
            ['category' => 'Otro'],
        ];
        DB::table('categories')->insert($category);
    }
}
