<?php
namespace App\Http\Interfaces;

interface usuarioInterface{
    public function create($grupo);
    public function likes($datos,$like);
    public function likes_comentarios($datos,$like);
    public function store($request);
    public function editar_pregunta($request,$id);
    public function guardar_comentarios($request,$id);
    public function filtrado($grupo,$palabra);
    public function eliminar_comentarios($id);
    public function editar_comentarios($request,$id);
}
