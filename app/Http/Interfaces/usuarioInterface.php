<?php
namespace App\Http\Interfaces;

interface usuarioInterface{
    public function index($grupo);
    public function create($grupo);
    public function comentarios($id);
    public function comentarios_init($id);
    public function likes($id_pregunta);
    public function likes_comentarios($datos);
    public function store($request);
    public function editar_pregunta($request,$id);
    public function guardar_comentarios($request,$id);
    public function filtrado($grupo,$palabra);
    public function eliminar_comentarios($id);
    public function editar_comentarios($request,$id);
}
