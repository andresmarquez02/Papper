<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function categories(){
        return response()->json(["categories" => Category::where("status",1)->get()], 200);
    }
}
