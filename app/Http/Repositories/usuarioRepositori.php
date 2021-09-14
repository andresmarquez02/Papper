<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\usuarioInterface;
use Auth;
use Session;
use DB;
use Cache;

class usuarioRepositori implements usuarioInterface
{
    public function index($grupo)
    {
        if($grupo == 0){
            $preguntas = $this->preConsulta()->get();
            $grupo = [];
        }
        else if($grupo == -1){
            $preguntas = $this->preConsulta()
            ->orderBy('likes','desc')
            ->orderBy('comentarios','desc')
            ->get();
            $grupo = collect(['id' => -1, 'grupo' => 'Populares']);
        }
        else{
            $preguntas = $this->preConsulta()
            ->where('id_grupo',$grupo)
            ->get();
            $grupo = Cache::get('grupos')->where("id",$grupo);
        }
        return response()->json([ "preguntas" => $preguntas, "grupo" => $grupo, "likes" => []]);
    }
    public function create($grupo)
    {
        if(! Cache::has('likes')){
            $likes = DB::table('likes')->where("id_usuario",auth()->user()->id)->get();
            Cache::add('likes', $likes, 3000);
        }
        else{
            $likes = Cache::get('likes');
        }
        if($grupo == 0){
            $preguntas = $this->preConsulta()->get();
            $grupo = [];
        }
        else if($grupo == -1){
            $preguntas = $this->preConsulta()
            ->orderBy('likes','desc')
            ->orderBy('comentarios','desc')
            ->get();
            $grupo = collect(['id' => -1, 'grupo' => 'Populares']);
        }
        else if($grupo == -2){
            if(! Cache::has('mis_preguntas')){
                Cache::forever('mis_preguntas', $this->preConsulta()
                ->where('id_usuario',Auth::user()->id)
                ->get());
            }
            $preguntas = Cache::get('mis_preguntas');
            $grupo = [];
        }
        else{
            $preguntas = $this->preConsulta()
            ->where('id_grupo',$grupo)
            ->get();
            $grupo = Cache::get('grupos')->where("id",$grupo);
        }
        return response()->json([ "preguntas" => $preguntas, "grupo" => $grupo, "likes" => $likes]);
    }
    private function preConsulta(){
        return DB::table('preguntas')
        ->join('users','users.id','=','preguntas.id_usuario')
        ->select('preguntas.*','nombre_apellido');
    }
    public function comentarios_init($id){
        $datos = DB::table('comentarios')->where('id_pregunta',$id)
        ->leftjoin('users','users.id','=','comentarios.id_usuario')
        ->select('comentarios.id','comentario','id_usuario','id_admin','id_pregunta','likes',
        'nombre_apellido')->get();
        $pregunta = DB::table('preguntas')
        ->leftjoin('users','users.id','=','preguntas.id_usuario')
        ->select('preguntas.*','nombre_apellido')->where("preguntas.id",$id)->first();

        return json_encode(["pregunta"=> $pregunta,"esLike" => [],"comentarios" => $datos, "likes_comentarios" => []],200);
    }
    public function comentarios($id){
        $datos = DB::table('comentarios')->where('id_pregunta',$id)
        ->leftjoin('users','users.id','=','comentarios.id_usuario')
        ->select('comentarios.id','comentario','id_usuario','id_admin','id_pregunta','likes',
        'nombre_apellido')->get();
        $pregunta = DB::table('preguntas')
        ->leftjoin('users','users.id','=','preguntas.id_usuario')
        ->select('preguntas.*','nombre_apellido')->where("preguntas.id",$id)->first();
        $esLike = DB::table('likes')->where("id_pregunta",$id)->where("id_usuario",auth()->user()->id)->count();

        $likes_comentarios = DB::table('like_comentario')->where('id_pregunta',$id)->where('id_user',Auth::user()->id)
        ->get();

        return json_encode(["pregunta"=> $pregunta,"esLike" => $esLike,"comentarios" => $datos, "likes_comentarios" => $likes_comentarios],200);
    }
    public function likes($id_pregunta){
        DB::beginTransaction();
        try {
            if(! Cache::has('likes')){
                $likes = DB::table('likes')->where("id_usuario",auth()->user()->id)->get();
                Cache::add('likes', $likes, 3000);
            }
            else{
                $likes = Cache::get('likes');
            }
            if($likes->where('id_pregunta', $id_pregunta)->count() > 0){
                DB::table('likes')->where('id_pregunta', $id_pregunta)->where('id_usuario', Auth::user()->id)->delete();
                DB::table('preguntas')->where('id', $id_pregunta)->decrement('likes', 1);
                DB::table('notificaciones')->where('id_pregunta',$id_pregunta)
                ->where('id_user_autor',Auth::user()->id)->delete();
                $cantidad_likes = DB::table('preguntas')->where('id',$id_pregunta)->value('likes');
            }
            else{
                $id_admin = DB::table('preguntas')->where('id',$id_pregunta)->value('id_usuario');
                DB::table('preguntas')->where('id', $id_pregunta)->increment('likes', 1);
                DB::table('likes')->insert([
                    'like' => 'SI',
                    'id_usuario' => Auth::user()->id,
                    'id_admin' => $id_admin,
                    'id_pregunta' => $id_pregunta,
                ]);
                DB::table('notificaciones')->insert([
                    'id_user_autor' => Auth::user()->id,
                    'descripcion' => Auth::user()->nombre_apellido.' Le ha dado like a tu publicación',
                    'id_admin' => $id_admin,
                    'id_pregunta' => $id_pregunta,
                    'vista' => 'No',
                ]);
                $cantidad_likes = DB::table('preguntas')->where('id',$id_pregunta)->value('likes');
            }
            Cache::pull('likes');
            DB::commit();
            return response()->json($cantidad_likes);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["Error recargue el sitio"],500);
        }

    }
    public function likes_comentarios($datos){
        $likes_comentarios = DB::table('like_comentario')->where('id_comentario',$datos)->where('id_user',Auth::user()->id)
        ->count();
        if($likes_comentarios > 0){
            DB::beginTransaction();
            try {
                $id_pregunta = DB::table('comentarios')->where('id',$datos)->value('id_pregunta');
                DB::table('like_comentario')->where('id_comentario',$datos)
                ->where('id_user',Auth::user()->id)->delete();
                DB::table('comentarios')->where('id',$datos)->decrement('likes', 1);
                DB::commit();
                return json_encode(1,200);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();
                return json_encode("Error");
            }
        }
        else {
            DB::beginTransaction();
            try {
                $comentario = DB::table('comentarios')->where('id',$datos)->first();
                DB::table('comentarios')->where('id',$datos)->increment('likes', 1);
                DB::table('like_comentario')->insert([
                    'like' => 'SI',
                    'id_pregunta' => $comentario->id_pregunta,
                    'id_admin' => $comentario->id_admin,
                    'id_comentario' => $datos,
                    'id_user_admin_comentario' => $comentario->id_usuario,
                    'id_user' => Auth::user()->id,
                ]);
                DB::table('notificaciones')->insert([
                    'id_user_autor' => Auth::user()->id,
                    'descripcion' => Auth::user()->nombre_apellido.' Le ha dado like a tu tu comentario en una publicación',
                    'id_admin' => $comentario->id_admin,
                    'id_pregunta' => $datos,
                    'vista' => 'No',
                ]);
                DB::table('notificaciones')->insert([
                    'id_user_autor' => Auth::user()->id,
                    'descripcion' => Auth::user()->nombre_apellido.' Ha interactuado con un like en tu publicación',
                    'id_admin' => $comentario->id_admin,
                    'id_pregunta' => $comentario->id_pregunta,
                    'vista' => 'No',
                ]);
                DB::commit();
                return json_encode(1);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();
                return json_encode("Error");
            }
        }
    }
    public function store($request){
        $fecha = date('Y-m-d');
        DB::table('preguntas')->insert([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'id_grupo' => $request->grupo,
            'id_usuario' => Auth::user()->id,
            'likes' => 0,
            'comentarios' => 0,
        ]);
        $publicado = "Publicado";
        Cache::pull('mis_preguntas');
        return $publicado;
    }
    public function editar_pregunta($request,$id){
        DB::beginTransaction();
        try {
            $fecha = date('Y-m-d');
            DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->update([
                'titulo'=> $request->titulo,
                'descripcion'=> $request->descripcion,
                'id_grupo'=> $request->id_grupo,
                'updated_at'=>$fecha
            ]);
            DB::commit();
            Cache::pull('mis_preguntas');
            return "Exito";
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }
    public function guardar_comentarios($request,$id){
        DB::beginTransaction();
        try {
            $id_admin = DB::table('preguntas')->where('id',$id)->value('id_usuario');
            DB::table('preguntas')->where('id',$id)->increment('comentarios',1);
            DB::table('comentarios')->insert([
                'comentario' => $request->comentario,
                'id_usuario' => Auth::user()->id,
                'id_admin' => $id_admin,
                'id_pregunta' => $id,
                'likes' => 0
            ]);
            DB::table('notificaciones')->insert([
                'id_user_autor' => Auth::user()->id,
                'descripcion' => Auth::user()->nombre_apellido.' Ha comentado en tu publicación',
                'id_admin' => $id_admin,
                'id_pregunta' => $id,
                'vista' => 'No',
            ]);
            DB::commit();
            $datos = 1;
            return json_encode($datos);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $datos = 0;
            return json_encode($datos);
        }
    }
    public function editar_comentarios($request,$id){
        DB::beginTransaction();
        try {
            $id_admin = DB::table('comentarios')->where('id',$id)->where('id_usuario',Auth::user()->id)->value('id_admin');
            DB::table('comentarios')->where('id',$id)->where('id_usuario',Auth::user()->id)->update([
                'comentario'=> $request->comentario,
            ]);
            DB::table('notificaciones')->insert([
                'id_user_autor' => Auth::user()->id,
                'descripcion' => Auth::user()->nombre_apellido.' Ha editado su comentario en una de tus publicaciones',
                'id_admin' => $id_admin,
                'id_pregunta' => $id,
                'vista' => 'No',
            ]);
            DB::commit();
            return "Exito";
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }
    public function eliminar_comentarios($id){
        DB::beginTransaction();
        try {
            $id_pregunta = DB::table('comentarios')->where('id',$id)->value('id_pregunta');
            $id_admin = DB::table('comentarios')->where('id',$id)->value('id_admin');
            DB::table('preguntas')->where('id',$id_pregunta)->update("comentarios",1);
            DB::table('comentarios')->where('id',$id)->where('id_usuario',Auth::user()->id)
            ->delete();
            DB::table('notificaciones')->insert([
                'id_user_autor' => Auth::user()->id,
                'descripcion' => Auth::user()->nombre_apellido.' Ha eliminado un comentario en una de tus publicaciones',
                'id_admin' => $id_admin,
                'id_pregunta' => $id_pregunta,
                'vista' => 'No',
            ]);
            DB::commit();
            return "Exito";
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }
    public function filtrado($grupo,$palabra){
        if($grupo == 0){
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('titulo','like',"%".$palabra."%")
            ->Orwhere('descripcion','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->get();
            return json_encode(["grupo" => [], "preguntas" => $preguntas],200);
        }
        else if($grupo == -1){
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('titulo','like',"%".$palabra."%")
            ->Orwhere('descripcion','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->orderBy('likes','desc')
            ->orderBy('comentarios','desc')
            ->get();
            return json_encode(["grupo" => collect(["id"=> -1, "grupo" => "Populares"]), "preguntas" => $preguntas],200);
        }
        else if($grupo == -2){
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('id_usuario',Auth::user()->id)
            ->where('titulo','like',"%".$palabra."%")
            ->Orwhere('descripcion','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->get();
            return json_encode(["grupo" => [], "preguntas" => $preguntas],200);
        }
        else{
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('id_grupo',$grupo)
            ->where('titulo','like',"%".$palabra."%")
            ->Orwhere('descripcion','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->get();
            return json_encode(["grupo" => Cache::get("grupos")->where('id',$grupo), "preguntas" => $preguntas],200);
        }
    }
}
