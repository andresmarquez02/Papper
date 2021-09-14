<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\usuarioInterface;
use App\Http\Requests\preguntaRequest;
use App\Http\Requests\EditPregRequest;
use Auth;
use Session;
use DB;
use Cache;

class usuarioController extends Controller
{
    public $repositori = null;
    public function __construct(usuarioInterface $repositori){
        $this->repositori = $repositori;
    }
    public function index()
    {
        return view('papper.home');
    }
    public function create($grupo)
    {
        if(auth()->user()) return $this->repositori->create($grupo);
        else return $this->repositori->index($grupo);
    }
    public function usuario()
    {
        if(! Cache::has('usuario')){
            Cache::forever('usuario', Auth::user());
        }
        return response()->json(Cache::get('usuario'));
    }
    public function grupos()
    {
        if(! Cache::has('grupos')){
            Cache::forever('grupos', DB::table('grupos')->orderBy('grupo')->get());
        }
        return response()->json(Cache::get('grupos'));
    }
    public function likes($id_pregunta)
    {
        return $this->repositori->likes($id_pregunta);
    }
    public function likes_comentarios($datos)
    {
        return $this->repositori->likes_comentarios($datos);
    }
    public function notificaciones(){
        $datos = DB::table('notificaciones')->where('id_admin',Auth::user()->id)
        ->where('id_user_autor','!=',Auth::user()->id)
        ->orderBy('id','desc')->get();
        return json_encode($datos);
    }
    public function store(preguntaRequest $request)
    {
        return $this->repositori->store($request);
    }
    public function editar_pregunta(EditPregRequest $request,$id)
    {
       return $this->repositori->editar_pregunta($request,$id);
    }
    public function eliminar_pregunta($id){
        $preguntas = DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->count();
        if($preguntas > 0)return response()->json([], 500);
        Cache::pull('mis_preguntas');
        DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->delete();
        DB::table('notificaciones')->where("id_pregunta",$id)->delete();
        DB::table('likes')->where("id_pregunta",$id)->delete();
        DB::table('like_comentario')->where("id_pregunta",$id)->delete();
        DB::table('comentarios')->where("id_pregunta",$id)->delete();
        return "Exito";
    }
    public function comentarios($id)
    {
        if(auth()->user()) return $this->repositori->comentarios($id);
        else return $this->repositori->comentarios_init($id);
    }
    public function guardar_comentarios(Request $request,$id){
        return $this->repositori->guardar_comentarios($request,$id);
    }
    public function editar_comentarios(Request $request,$id){
        $this->validate($request,[
            'comentario' => 'required|string|min:2',
        ]);
        return $this->repositori->editar_comentarios($request,$id);
    }
    public function eliminar_comentarios($id){
        return $this->repositori->eliminar_comentarios($id);
    }
    public function filtrado($grupo,$palabra){
        return $this->repositori->filtrado($grupo,$palabra);
    }
    public function logout()
    {
        session()->flush();
        Cache::flush();
        Auth::logout();
        return redirect('/');
    }
}
