<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class login_register extends Controller
{
    public function index()
    {
        return view('papper.index');
    }

    public function store(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->correo, 'password' => $request->contrasena])){
            return response()->json(200);
        }
        else{
            return response()->json(["error"=>"Las credenciales son incorrectas."], 500);
        }
    }

    public function register(RegistroRequest $request){

        DB::beginTransaction();
        try {
            DB::table('users')->insert([
                'nombre_apellido' => $request->usuario,
                'email' => $request->correo,
                'password' => bcrypt($request->contrasena),
            ]);
            DB::commit();
            return response()->json(["exito" => "Cuenta creada con exito"], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error"=>"Error inesperado, intenta mas tarde"], 500);
        }
    }
}
