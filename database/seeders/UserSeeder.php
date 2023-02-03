<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                "username" => "admin",
                "email" => "admin@papper.com",
                "password" => bcrypt("123123"),
                "role_id" => 1,
                "email_verified_at" => date("Y-m-d H:i:s"),
            ],
            [
                "username" => "andres",
                "email" => "andres03marquez@gmail.com",
                "password" => bcrypt("123123"),
                "role_id" => 2,
                "email_verified_at" => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
