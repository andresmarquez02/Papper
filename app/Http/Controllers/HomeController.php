<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function categories(){
        return response()->json(["categories" => Category::where("status",1)->get()], 200);
    }
}
