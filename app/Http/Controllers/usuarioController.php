<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\usuarioInterface;
use App\Http\Requests\preguntaRequest;
use App\Http\Requests\EditPregRequest;
use Auth;
use Session;
use DB;
class usuarioController extends Controller
{
    public $repositori = null;
    public function __construct(usuarioInterface $repositori){
        $this->repositori = $repositori;
    }
    public function index()
    {
        return view('papper.home');
    }
    public function create($grupo)
    {
        return $this->repositori->create($grupo);
    }
    public function usuario()
    {
        return response()->json(Auth::user());
    }
    public function grupos()
    {
        return response()->json(DB::table('grupos')->orderBy('grupo')->get());
    }
    public function mylike($id_pregunta)
    {
        $datos = DB::table('likes')->where('id_pregunta',$id_pregunta)->where('id_usuario',Auth::user()->id)
        ->count();
        return response()->json($datos);
    }
    public function mylike_comentarios($id_comentario)
    {
        $datos = DB::table('like_comentario')->where('id_comentario',$id_comentario)->where('id_user',Auth::user()->id)
        ->count();
        return response()->json($datos);
    }
    public function likes($datos,$like)
    {
        return $this->repositori->likes($datos,$like);
    }
    public function likes_comentarios($datos,$like)
    {
        return $this->repositori->likes_comentarios($datos,$like);
    }
    public function notificaciones(){
        $datos = DB::table('notificaciones')->where('id_admin',Auth::user()->id)
        ->where('id_user_autor','!=',Auth::user()->id)
        ->orderBy('id','desc')->get();
        return json_encode($datos);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(preguntaRequest $request)
    {
        return $this->repositori->store($request);
    }
    public function editar_pregunta(EditPregRequest $request,$id)
    {
       return $this->repositori->editar_pregunta($request,$id);
    }
    public function eliminar_pregunta($id){
        DB::table('preguntas')->where('id',$id)->where('id_usuario',Auth::user()->id)->delete();
        return "Exito";
    }
    public function comentarios($id)
    {
        $datos = DB::table('comentarios')->where('id_pregunta',$id)
        ->join('users','users.id','=','comentarios.id_usuario')
        ->select('comentarios.id','comentario','id_usuario','id_admin','id_pregunta','likes',
        'nombre_apellido')->get();
        return json_encode($datos);
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
    public function filtrado($grupo,$palabra){
        return $this->repositori->filtrado($grupo,$palabra);
    }
    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
