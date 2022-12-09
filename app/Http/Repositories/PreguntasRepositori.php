<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\PreguntasInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PreguntasRepositori implements PreguntasInterface
{
    public function preguntas(){
        return response()->json([ "preguntas" => $this->consultaPreguntas()]);
    }

    public function preguntasPopulares(){
        $preguntas = $this->consultaPreguntas()
        ->sortByDesc("likes")
        ->sortByDesc('comentarios')
        ->values()->all();

        return response()->json([ "preguntas" => $preguntas]);
    }

    public function preguntasRecomendadas(){
        $preguntas = $this->consultaPreguntas()
        ->whereIn('grupo', ["Lexachange", "Lexa","change"])
        ->sortByDesc('likes')
        ->sortByDesc('comentarios')
        ->values()->all();

        return response()->json([ "preguntas" => $preguntas]);
    }

    public function preguntasPorGrupo($grupo){
        $preguntas = $this->consultaPreguntas()
        ->where('id_grupo',$grupo);

        return response()->json([ "preguntas" => $preguntas]);
    }

    public function buscarPreguntas($grupo,$palabra){
        $preguntas = $this->consultaPreguntas();

        if(!empty($grupo)){
            $preguntas = $preguntas->where('id_grupo',$grupo);
        }

        $preguntas = $preguntas->filter(function($pregunta) use($palabra) {
            if(Str::contains($pregunta->titulo, $palabra)){
                return $pregunta;
            }
            else if(Str::contains($pregunta->descripcion, $palabra)){
                return $pregunta;
            }
        });

        return response()->json([
            "grupo" => Cache::get("grupos")->where('id',$grupo),
            "preguntas" => $preguntas
        ],200);
    }

    private function consultaPreguntas(){
        return DB::table('preguntas')
        ->join('users','users.id','=','preguntas.id_usuario')
        ->join('grupos','grupos.id','preguntas.id_grupo')
        ->select('preguntas.*','nombre_apellido','grupos.grupo')
        ->orderByDesc("created_at")
        ->get()
        ->each(function($pregunta){
            $pregunta->created_at = Carbon::parse($pregunta->created_at)->diffForHumans();
        });
    }

    public function crearPregunta($request){
        DB::transaction(function () use ($request){
            DB::table('preguntas')->insert([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'id_grupo' => $request->grupo,
                'id_usuario' => auth()->user()->id,
                'likes' => 0,
                'comentarios' => 0,
            ]);
            Cache::pull('mis_preguntas');
        });
        return response()->json(["exito" => "Publicacion creada con exito"], 200);
    }

    public function actualizarPregunta($request,$id){
        DB::beginTransaction();
        try {
            $fecha = date('Y-m-d');
            DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->update([
                'titulo'=> $request->titulo,
                'descripcion'=> $request->descripcion,
                'id_grupo'=> $request->id_grupo,
                'updated_at'=> $fecha
            ]);
            DB::commit();
            Cache::pull('mis_preguntas');
            return response()->json(["exito" => "Publicacion editada con exito"],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }

    public function eliminarPregunta($id){
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
            return response()->json([], 200);;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([], 500);
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
            // return $th;
            DB::rollback();
            return response()->json(["Error recargue el sitio",$th],500);
        }

    }
}
