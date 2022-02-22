<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ComentariosInterface;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public $repositori = null;

    public function __construct(ComentariosInterface $repositori){
        $this->repositori = $repositori;
    }

    public function likes_comentarios($datos){
        return $this->repositori->likes_comentarios($datos);
    }

    public function comentarios($id){
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
}
