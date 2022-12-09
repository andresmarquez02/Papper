<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ComentariosInterface;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public $interface = null;

    public function __construct(ComentariosInterface $interface){
        $this->interface = $interface;
    }

    public function likesComentarios($datos){
        return $this->interface->likesComentarios($datos);
    }

    public function comentarios($id){
        return $this->interface->comentarios($id);
    }

    public function guardarComentario(Request $request,$id){
        return $this->interface->guardarComentario($request,$id);
    }

    public function actualizarComentario(Request $request,$id){
        $this->validate($request,[
            'comentario' => 'required|string|min:2',
        ]);
        return $this->interface->actualizarComentario($request,$id);
    }

    public function eliminarComentario($id){
        return $this->interface->eliminarComentario($id);
    }
}
