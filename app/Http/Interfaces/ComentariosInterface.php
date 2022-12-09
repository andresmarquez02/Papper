<?php
namespace App\Http\Interfaces;

interface ComentariosInterface{
    public function comentarios($id);
    public function likesComentarios($datos);
    public function guardarComentario($request,$id);
    public function eliminarComentario($id);
    public function actualizarComentario($request,$id);
}
