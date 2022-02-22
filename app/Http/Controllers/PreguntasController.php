<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PreguntasInterface;
use App\Http\Requests\EditPregRequest;
use App\Http\Requests\preguntaRequest;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    public $repositori = null;

    public function __construct(PreguntasInterface $repositori){
        $this->repositori = $repositori;
    }

    public function index(){
        return view('papper.home');
    }

    public function preguntas($grupo){

        if(auth()->user()) return $this->repositori->preguntas($grupo);
        else return $this->repositori->index($grupo);
    }

    public function store(preguntaRequest $request){
        return $this->repositori->store($request);
    }

    public function editar_pregunta(EditPregRequest $request,$id){
       return $this->repositori->editar_pregunta($request,$id);
    }

    public function eliminar_pregunta($id){
        return $this->repositori->eliminar_pregunta($id);
    }

    public function filtrado($grupo,$palabra){
        return $this->repositori->filtrado($grupo,$palabra);
    }

    public function likes($id_pregunta){
        return $this->repositori->likes($id_pregunta);
    }
}
