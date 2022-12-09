<?php

use Illuminate\Support\Facades\Route;
// DB::listen(function($query){
//     echo $query->sql;
// });

// Ruta inicial
Route::get('/', 'HomeController@index');

//Rutas para preguntas
Route::get('preguntas', 'PreguntasController@preguntas');
Route::get('preguntas/populares', 'PreguntasController@preguntasPopulares');
Route::get('preguntas/recomendadas', 'PreguntasController@preguntasRecomendadas');
Route::get('preguntas/{grupo}', 'PreguntasController@preguntasPorGrupo');
Route::get('preguntas/buscar/{grupo}/{palabra}', 'PreguntasController@buscarPreguntas');

// Comentarios
Route::get('comentarios/{id}', 'ComentariosController@comentarios');

// Grupos
Route::get('grupos', 'usuarioController@grupos');

// Rutas solo para cuando no se este logueado
Route::middleware(['guest'])->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

Route::middleware(['auth'])->group(function () {
    //usuario y datos
    // Route::get('/home', 'usuarioController@index');
    Route::post('usuario', 'usuarioController@usuario');
    Route::get('notificaciones', 'usuarioController@notificaciones');

    //Preguntas
    Route::post('crear/pregunta', 'PreguntasController@crearPregunta');
    Route::put('actualizar/pregunta/{id}', 'PreguntasController@actualizarPregunta');
    Route::delete('eliminar/pregunta/{id}', 'PreguntasController@eliminarPregunta');
    Route::post('like/{idPregunta}', 'PreguntasController@likes');

    //Comentarios
    Route::post('guardar/comentario/{id}', 'ComentariosController@guardarComentario');
    Route::post('like/comentario/{like}', 'ComentariosController@likesComentarios');
    Route::post('eliminar/comentario/{id}', 'ComentariosController@eliminarComentario');
    // Route::post('actualizar/comentario/{id}', 'usuarioController@actualizarComentario');

    // Desloguearme
    Route::get('logout', 'AuthController@logout');
});

