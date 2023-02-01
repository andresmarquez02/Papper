<?php

namespace App\Http\Controllers;

use App\Denunciation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DenunciationController extends Controller
{

    public function index()
    {
        return response()->json(["denunciations" => Denunciation::all()],200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            "denunciation" => "required|unique:denunciations,denunciation",
        ]);

        Denunciation::create([
            "denunciation" => $request->denunciation
        ]);

        return response()->json([],200);

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "denunciation" => "required",
            "denunciation" => Rule::unique("denunciations")->ignore($id),
        ]);

        Denunciation::where("id",$id)->update([
            "denunciation" => $request->denunciation
        ]);

        return response()->json([],200);
    }

    public function show($id)
    {
        DB::transaction(function () use ($id) {
            $denunciation = Denunciation::find($id);
            $denunciation->status = !$denunciation->status;
            $denunciation->save();
        });

        return response()->json([],200);
    }

    public function destroy($id)
    {
        Denunciation::where("id",$id)->delete();
        return response()->json([],200);
    }
}
