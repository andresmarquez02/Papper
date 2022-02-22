<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\ComentariosInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ComentariosRepositori implements ComentariosInterface
{
    public function comentarios_init($id){
        $datos = DB::table('comentarios')->where('id_pregunta',$id)
        ->leftjoin('users','users.id','=','comentarios.id_usuario')
        ->select('comentarios.id','comentario','id_usuario','id_admin','id_pregunta','likes',
        'nombre_apellido')->get();
        $pregunta = DB::table('preguntas')
        ->leftjoin('users','users.id','=','preguntas.id_usuario')
        ->leftjoin('grupos','grupos.id','preguntas.id_grupo')
        ->select('preguntas.*','nombre_apellido','grupos.grupo')->where("preguntas.id",$id)->first();

        $pregunta->created_at = Carbon::parse($pregunta->created_at)->diffForHumans();
        return json_encode(["pregunta"=> $pregunta,"esLike" => [],"comentarios" => $datos, "likes_comentarios" => []],200);
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
            return response()->json(["exito" => "Publicacion editada con exito"], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error" => "Error inesperado, intenta más tarde."], 500);
        }
    }

    public function eliminar_comentarios($id){
        DB::beginTransaction();
        try {
            $id_pregunta = DB::table('comentarios')->where('id',$id)->value('id_pregunta');
            $id_admin = DB::table('comentarios')->where('id',$id)->value('id_admin');
            DB::table('preguntas')->where('id',$id_pregunta)->update(["comentarios" => 1]);
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
            return response()->json(["exito" => "Comentario eliminado con exito."], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(["error" => "Error inesperado intenta mas tarde."], 200);
        }
    }

    public function comentarios($id){
        $datos = DB::table('comentarios')->where('id_pregunta',$id)
        ->leftjoin('users','users.id','=','comentarios.id_usuario')
        ->select('comentarios.id','comentario','id_usuario','id_admin','id_pregunta','likes',
        'nombre_apellido')->get();
        $pregunta = DB::table('preguntas')
        ->leftjoin('users','users.id','=','preguntas.id_usuario')
        ->leftjoin('grupos','grupos.id','preguntas.id_grupo')
        ->select('preguntas.*','nombre_apellido','grupos.grupo')->where("preguntas.id",$id)->first();
        $esLike = DB::table('likes')->where("id_pregunta",$id)->where("id_usuario",auth()->user()->id)->count();

        $likes_comentarios = DB::table('like_comentario')->where('id_pregunta',$id)->where('id_user',Auth::user()->id)
        ->get();
        $pregunta->created_at = Carbon::parse($pregunta->created_at)->diffForHumans();
        return json_encode(["pregunta"=> $pregunta,"esLike" => $esLike,"comentarios" => $datos, "likes_comentarios" => $likes_comentarios],200);
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
}
