<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class usuarioController extends Controller
{
    public function index(){
        return view('papper.home');
    }
    public function usuario(){
        if(! Cache::has('usuario')){
            Cache::forever('usuario', Auth::user());
        }
        return response()->json(Cache::get('usuario'));
    }

    public function grupos(){
        if(! Cache::has('grupos')){
            Cache::forever('grupos', DB::table('grupos')->orderBy('grupo')->get());
        }
        return response()->json(Cache::get('grupos'));
    }

    public function notificaciones(){
        $datos = DB::table('notificaciones')->where('id_admin',Auth::user()->id)
        ->where('id_user_autor','!=',Auth::user()->id)
        ->orderBy('id','desc')->get();
        return json_encode($datos);
    }

    public function logout()
    {
        session()->flush();
        Cache::flush();
        Auth::logout();
        return redirect('/');
    }
}
