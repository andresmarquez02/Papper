<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Verificacion de los datos y logueo
        if(Auth::attempt(['email' => $request->correo, 'password' => $request->contrasena])){
            return response()->json(["exito" => "Iniciando Sesion"],200);
        }
        else{
            return response()->json(["errors" => ["err" => ["Las credenciales son incorrectas"]]], 402);
        }
    }

    public function register(RegistroRequest $request){
        // Inicio de la transaccion
        DB::beginTransaction();
        try {
            // GUardado del usuario en la bd
            User::create([
                'nombre_apellido' => $request->usuario,
                'email' => $request->correo,
                'password' => bcrypt($request->contrasena),
            ]);
            // COmmit a la transaccion para que se ejecuten los cambios
            DB::commit();
            // Respuesta final
            return response()->json(["exito" => "Cuenta creada con exito"], 200);
        } catch (\Throwable $th) {
            // Rollback para que los cambios se borren
            DB::rollback();
            // Respuesta de error
            return response()->json(["errors" => ["err" => ["Error inesperado, intenta mas tarde"]]], 402);
        }
    }

    public function logout(){
        session()->flush();
        Cache::flush();
        Auth::logout();
        return redirect('/');
    }
}
