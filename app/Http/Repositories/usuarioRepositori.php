<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\usuarioInterface;
use Auth;
use Session;
use DB;

class usuarioRepositori implements usuarioInterface
{
    public function create($grupo)
    {
        if($grupo == 0){
            $preguntas = $this->preConsulta()->get();
            return response()->json(["preguntas" => $preguntas, "grupo" => []]);
        }
        else if($grupo == -1){
            $preguntas = $this->preConsulta()
            ->orderBy('likes','desc')
            ->orderBy('comentarios','desc')
            ->get();
            return response()->json(["preguntas" => $preguntas, "grupo" => collect(['id' => -1, 'grupo' => 'Populares'])]);
        }
        else if($grupo == -2){
            $preguntas = $this->preConsulta()
            ->where('id_usuario',Auth::user()->id)
            ->get();
            return response()->json(["preguntas" => $preguntas, "grupo" => []]);
        }
        else{
            $preguntas = $this->preConsulta()
            ->where('id_grupo',$grupo)
            ->get();
            return response()->json([ "preguntas" => $preguntas, "grupo" => DB::table('grupos')->find($grupo)]);
        }
    }
    private function preConsulta(){
        return DB::table('preguntas')
        ->join('users','users.id','=','preguntas.id_usuario')
        ->select('preguntas.*','nombre_apellido');
    }
    public function likes($datos,$like){
        DB::beginTransaction();
        try {
            if($like == 0){
                DB::table('likes')->where('id_pregunta', $datos)->where('id_usuario', Auth::user()->id)->delete();
                DB::table('preguntas')->where('id', $datos)->decrement('likes', 1);
                DB::table('notificaciones')->where('id_pregunta',$datos)
                ->where('id_user_autor',Auth::user()->id)->delete();
                $cantidad_likes = DB::table('preguntas')->where('id',$datos)->value('likes');
            }
            else if($like == 1){

                $id_admin = DB::table('preguntas')->where('id',$datos)->value('id_usuario');
                DB::table('preguntas')->where('id', $datos)->increment('likes', 1);
                DB::table('likes')->insert([
                    'like' => 'SI',
                    'id_usuario' => Auth::user()->id,
                    'id_admin' => $id_admin,
                    'id_pregunta' => $datos,
                ]);
                DB::table('notificaciones')->insert([
                    'id_user_autor' => Auth::user()->id,
                    'descripcion' => Auth::user()->nombre_apellido.' Le ha dado like a tu publicación',
                    'id_admin' => $id_admin,
                    'id_pregunta' => $datos,
                    'vista' => 'No',
                ]);
                $cantidad_likes = DB::table('preguntas')->where('id',$datos)->value('likes');

            }
            DB::commit();
            return response()->json($cantidad_likes);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["Error recargue el sitio"]);
        }

    }
    public function likes_comentarios($datos,$like){
        if($like == 0){
            DB::beginTransaction();
            try {
                $cantidad_likes = DB::table('comentarios')->where('id',$datos)->value('likes');
                $id_pregunta = DB::table('comentarios')->where('id',$datos)->value('id_pregunta');
                $cantidad_likes = $cantidad_likes-1;
                DB::table('like_comentario')->where('id_comentario',$datos)
                ->where('id_user',Auth::user()->id)->delete();
                DB::table('comentarios')->where('id',$datos)->update([
                    'likes' => $cantidad_likes
                ]);
                DB::table('notificaciones')->where('id_pregunta',$id_pregunta)
                ->where('id_user_autor',Auth::user()->id)->delete();
                DB::commit();
                return json_encode($cantidad_likes);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();
                return json_encode("Error");
            }
        }
        if($like == 1){
            DB::beginTransaction();
            try {
                $cantidad_likes = DB::table('comentarios')->where('id',$datos)->value('likes');
                $id_admin = DB::table('comentarios')->where('id',$datos)->value('id_admin');
                $id_usuario = DB::table('comentarios')->where('id',$datos)->value('id_usuario');
                $id_pregunta = DB::table('comentarios')->where('id',$datos)->value('id_pregunta');
                $cantidad_likes = $cantidad_likes+1;
                DB::table('comentarios')->where('id',$datos)->update([
                    'likes' => $cantidad_likes
                ]);
                DB::table('like_comentario')->insert([
                    'like' => 'SI',
                    'id_pregunta' => $id_pregunta,
                    'id_admin' => $id_admin,
                    'id_comentario' => $datos,
                    'id_user_admin_comentario' => $id_usuario,
                    'id_user' => Auth::user()->id,
                ]);
                DB::table('notificaciones')->insert([
                    'id_user_autor' => Auth::user()->id,
                    'descripcion' => Auth::user()->nombre_apellido.' Le ha dado like a tu tu comentario en una publicación',
                    'id_admin' => $id_admin,
                    'id_pregunta' => $datos,
                    'vista' => 'No',
                ]);
                DB::table('notificaciones')->insert([
                    'id_user_autor' => Auth::user()->id,
                    'descripcion' => Auth::user()->nombre_apellido.' Ha interactuado con un like en tu publicación',
                    'id_admin' => $id_admin,
                    'id_pregunta' => $id_pregunta,
                    'vista' => 'No',
                ]);
                DB::commit();
                return json_encode($cantidad_likes);
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
            'create_at' => $fecha,
            'update_at' => $fecha,
        ]);
        $publicado = "Publicado";
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
                'update_at'=>$fecha
            ]);
            DB::commit();
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
            $cantidad_comentarios = DB::table('preguntas')->where('id',$id)->value('comentarios');
            $cantidad_comentarios = $cantidad_comentarios+1;
            DB::table('preguntas')->where('id',$id)->update(['comentarios' => $cantidad_comentarios]);
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
            $comentarios = DB::table('preguntas')->where('id',$id_pregunta)->value('comentarios');
            $comentarios = $comentarios-1;
            DB::table('preguntas')->where('id',$id_pregunta)->update(["comentarios" => $comentarios]);
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
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->get();
            $group = [];
            $datos['preguntas'] = $preguntas;
            $datos['grupo'] = $group;
            return json_encode($datos);
        }
        else if($grupo == -1){
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('titulo','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->orderBy('likes','desc')
            ->orderBy('comentarios','desc')
            ->get();
            $group = DB::table('grupos')->where('id',1)->get();
            $group[0]->id = -1;
            $group[0]->grupo = 'Populares';
            $datos['preguntas'] = $preguntas;
            $datos['grupo'] = $group;
            return json_encode($datos);
        }
        else if($grupo == -2){
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('id_usuario',Auth::user()->id)
            ->where('titulo','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->get();
            $group = [];
            $datos['preguntas'] = $preguntas;
            $datos['grupo'] = $group;
            return json_encode($datos);
        }
        else{
            $preguntas = DB::table('preguntas')
            ->join('users','users.id','=','preguntas.id_usuario')
            ->where('id_grupo',$grupo)
            ->where('titulo','like',"%".$palabra."%")
            ->select('preguntas.id','preguntas.id_usuario','titulo','descripcion','likes',
            'comentarios','id_grupo','nombre_apellido')
            ->get();
            $group = DB::table('grupos')->where('id',$grupo)->get();
            $datos['preguntas'] = $preguntas;
            $datos['grupo'] = $group;
            return json_encode($datos);
        }
    }
}
