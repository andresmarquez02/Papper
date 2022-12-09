<?php
namespace App\Http\Interfaces;

interface PreguntasInterface{
    public function preguntas();
    public function preguntasPopulares();
    public function preguntasRecomendadas();
    public function preguntasPorGrupo($grupo);
    public function crearPregunta($request);
    public function actualizarPregunta($request,$id);
    public function eliminarPregunta($id);
    public function buscarPreguntas($grupo,$palabra);
    public function likes($id_pregunta);
}
