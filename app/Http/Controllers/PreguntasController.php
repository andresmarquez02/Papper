<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PreguntasInterface;
use App\Http\Requests\EditPregRequest;
use App\Http\Requests\preguntaRequest;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    public $interface = null;

    public function __construct(PreguntasInterface $preguntasInterface){
        $this->interface = $preguntasInterface;
    }

    public function preguntas(){
        return $this->interface->preguntas();
    }

    public function preguntasPopulares(){
        return $this->interface->preguntasPopulares();
    }

    public function preguntasRecomendadas(){
        return $this->interface->preguntasRecomendadas();
    }

    public function preguntasPorGrupo($grupo){
        return $this->interface->preguntasPorGrupo($grupo);
    }

    public function buscarPreguntas($grupo,$palabra){
        return $this->interface->buscarPreguntas($grupo,$palabra);
    }

    public function crearPregunta(preguntaRequest $request){
        return $this->interface->crearPregunta($request);
    }

    public function actualizarPregunta(EditPregRequest $request,$id){
       return $this->interface->actualizarPregunta($request,$id);
    }

    public function eliminarPregunta($id){
        return $this->interface->eliminarPregunta($id);
    }

    public function likes($idPregunta){
        return $this->interface->likes($idPregunta);
    }
}
