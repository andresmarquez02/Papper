<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(["categories" => Category::all()],200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "category" => "required|unique:categories,category"
        ]);

        DB::transaction(function () use ($request) {
            Category::create([
                "category" => $request->category
            ]);
        });

        return response()->json([],200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            "category" => "required",
            "category" => Rule::unique("categories")->ignore($id),
        ]);

        DB::transaction(function () use ($request, $id) {
            Category::find($id)->update([
                "category" => $request->category
            ]);
        });

        return response()->json([],200);
    }

    public function show($id)
    {
        DB::transaction(function () use ($id) {
            $category = Category::find($id);
            $category->status = !$category->status;
            $category->save();
        });

        return response()->json([],200);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            Category::find($id)->delete();
        });

        return response()->json([],200);
    }
}
