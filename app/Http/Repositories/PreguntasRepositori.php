<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\PreguntasInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PreguntasRepositori implements PreguntasInterface
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
        foreach ($preguntas as $value) {
            $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
        }
        return response()->json([ "preguntas" => $preguntas, "grupo" => $grupo, "likes" => []]);
    }
    public function preguntas($grupo)
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
        foreach ($preguntas as $value) {
            $value->created_at = Carbon::parse($value->created_at)->diffForHumans();
        }
        return response()->json([ "preguntas" => $preguntas, "grupo" => $grupo, "likes" => $likes]);
    }
    private function preConsulta(){
        return DB::table('preguntas')
        ->join('users','users.id','=','preguntas.id_usuario')
        ->join('grupos','grupos.id','preguntas.id_grupo')
        ->select('preguntas.*','nombre_apellido','grupos.grupo');
    }

    public function store($request){
        DB::transaction(function () use ($request){
            DB::table('preguntas')->insert([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'id_grupo' => $request->grupo,
                'id_usuario' => Auth::user()->id,
                'likes' => 0,
                'comentarios' => 0,
            ]);
            Cache::pull('mis_preguntas');
        });
        return response()->json(["exito" => "Publicacion creada con exito"], 200);
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
            return response()->json(["exito" => "Publicacion editada con exito"],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }

    public function eliminar_pregunta($id){
        DB::beginTransaction();
        try {
            $preguntas = DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->count();
            if($preguntas == 0)return response()->json([], 500);
            Cache::pull('mis_preguntas');
            DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->delete();
            DB::table('notificaciones')->where("id_pregunta",$id)->delete();
            DB::table('likes')->where("id_pregunta",$id)->delete();
            DB::table('like_comentario')->where("id_pregunta",$id)->delete();
            DB::table('comentarios')->where("id_pregunta",$id)->delete();
            DB::commit();
            return "Exito";
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([], 500);
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
}
