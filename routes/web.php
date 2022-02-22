<?php

use Illuminate\Support\Facades\Route;
// DB::listen(function($query){
//     echo $query->sql;
// });
Route::middleware(['guest'])->group(function () {
    Route::get('/', 'login_register@index');
    Route::post('login', 'login_register@store');
    Route::post('register', 'login_register@register');
});

//Rutas para preguntas y comentarios
Route::post('preguntas/{grupo}', 'PreguntasController@preguntas');
Route::post('comentarios/{id}', 'ComentariosController@comentarios');
Route::get('grupos', 'usuarioController@grupos');
Route::post('filtrado/{grupo}/{palabra}', 'PreguntasController@filtrado');

Route::middleware(['auth'])->group(function () {
    //usuario y datos
    Route::get('/home', 'usuarioController@index');
    Route::post('usuario', 'usuarioController@usuario');
    Route::get('notificaciones', 'usuarioController@notificaciones');

    //Preguntas
    Route::post('guardar', 'PreguntasController@store');
    Route::post('editar_pregunta/{id}', 'PreguntasController@editar_pregunta');
    Route::post('eliminar_pregunta/{id}', 'PreguntasController@eliminar_pregunta');
    Route::post('like/{id_pregunta}', 'PreguntasController@likes');

    //Comentarios
    Route::post('enviar/comentarios/{id}', 'ComentariosController@guardar_comentarios');
    Route::post('like/comentarios/{like}', 'ComentariosController@likes_comentarios');
    Route::post('eliminar_comentario/{id}', 'ComentariosController@eliminar_comentarios');
    // Route::post('/papper/editar_comentario/{id}', 'usuarioController@editar_comentarios');

    Route::get('logout', 'usuarioController@logout');
});

