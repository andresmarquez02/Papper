<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|min:5|max:100',
            'password' => 'required|min:5|max:254'
        ]);
        // Verificacion de los datos y logueo
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(["success" => "Iniciando Sesion"],200);
        }
        else{
            return response()->json(["errors" => ["err" => ["Las credenciales son incorrectas"]]], 402);
        }
    }

    public function register(Request $request){
        $this->validate($request,[
            'username' => 'required|string|min:5|max:100|unique:users,username',
            'email' => 'required|email|min:5|max:100|unique:users,email',
            'password' => 'required|min:5|max:254|confirmed'
        ]);
        // Inicio de la transaccion
        DB::beginTransaction();
        try {
            // GUardado del usuario en la bd
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => 2,
            ]);
            // COmmit a la transaccion para que se ejecuten los cambios
            DB::commit();
            // Respuesta final
            return response()->json(["success" => "Cuenta creada con exito"], 200);
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
