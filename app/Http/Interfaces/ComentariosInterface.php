<?php
namespace App\Http\Interfaces;

interface ComentariosInterface{
    public function comentarios($id);
    public function comentarios_init($id);
    public function likes_comentarios($datos);
    public function guardar_comentarios($request,$id);
    public function eliminar_comentarios($id);
    public function editar_comentarios($request,$id);
}
