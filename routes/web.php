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

Route::post('preguntas/{grupo}', 'usuarioController@create');
Route::post('comentarios/{id}', 'usuarioController@comentarios');
Route::get('grupos', 'usuarioController@grupos');
Route::post('filtrado/{grupo}/{palabra}', 'usuarioController@filtrado');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'usuarioController@index');
    Route::post('usuario', 'usuarioController@usuario');
    Route::post('preguntas/save/logs', 'usuarioController@store');
    Route::post('editar_pregunta/{id}', 'usuarioController@editar_pregunta');
    Route::post('eliminar_pregunta/{id}', 'usuarioController@eliminar_pregunta');
    Route::post('like/{id_pregunta}', 'usuarioController@likes');
    Route::post('enviar/comentarios/{id}', 'usuarioController@guardar_comentarios');
    Route::post('like/comentarios/{like}', 'usuarioController@likes_comentarios');
    // Route::post('/papper/editar_comentario/{id}', 'usuarioController@editar_comentarios');
    Route::post('eliminar_comentario/{id}', 'usuarioController@eliminar_comentarios');
    Route::get('logout', 'usuarioController@logout');
    Route::get('notificaciones', 'usuarioController@notificaciones');
});

