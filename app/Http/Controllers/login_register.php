<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
class login_register extends Controller
{
    public function index()
    {
        return view('papper.index');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'correo' => 'required|email|string|min:5',
            'contrasena' => 'required|string|min:5'
        ]);
        if(Auth::attempt(['email' => $request->correo, 'password' => $request->contrasena])){
            return "true";
        }
        else{
            return "false";
        }
    }
    public function register(Request $request)
    {
        $this->validate($request,[
            'an' => 'required|string|min:5|max:254',
            'correo' => 'required|email|string|min:5|max:254',
            'contrasena' => 'required|min:5|max:254'
        ]);
        $errorCorreo = DB::table('users')->where('email',$request->correo)->value('email');
        if(! empty($errorCorreo)){
            return "1";
        }
        $errorCorreo = DB::table('users')->where('nombre_apellido',$request->an)->value('nombre_apellido');
        if(! empty($errorCorreo)){
            return "4";
        }
        else{
            $contrasena = bcrypt($request->contrasena);
            $fecha = date('Y-m-d');
            DB::table('users')->insert([
                'nombre_apellido' => $request->an,
                'email' => $request->correo,
                'password' => $contrasena,
                'create_at' => $fecha,
                'update_at' => $fecha
            ]);
        }
        if(Auth::attempt(['email' => $request->correo, 'password' => $request->contrasena])){
            return "2";
        }
        else{
            return "3";
        }
    }
}
