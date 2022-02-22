<?php
namespace App\Http\Interfaces;

interface PreguntasInterface{
    public function index($grupo);
    public function preguntas($grupo);
    public function store($request);
    public function editar_pregunta($request,$id);
    public function eliminar_pregunta($id);
    public function filtrado($grupo,$palabra);
    public function likes($id_pregunta);
}
