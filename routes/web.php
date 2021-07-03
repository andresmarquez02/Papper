<?php
    Route::get('/', 'login_register@index');

Route::middleware(['guest'])->group(function () {
    Route::get('/', 'login_register@index');
    Route::post('login', 'login_register@store');
    Route::post('register', 'login_register@register');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/papper/home', 'usuarioController@index');
    Route::post('/papper/preguntas/{grupo}', 'usuarioController@create');
    Route::post('/papper/editar_pregunta/{id}', 'usuarioController@editar_pregunta');
    Route::post('/papper/eliminar_pregunta/{id}', 'usuarioController@eliminar_pregunta');
    Route::post('/papper/usuario', 'usuarioController@usuario');
    Route::post('/papper/like/{datos}/{like}', 'usuarioController@likes');
    Route::post('/papper/like/comentarios/{datos}/{like}', 'usuarioController@likes_comentarios');
    Route::post('/papper/comentarios/{id}', 'usuarioController@comentarios');
    Route::post('/papper/enviar/comentarios/{id}', 'usuarioController@guardar_comentarios');
    // Route::post('/papper/editar_comentario/{id}', 'usuarioController@editar_comentarios');
    Route::post('/papper/eliminar_comentario/{id}', 'usuarioController@eliminar_comentarios');
    Route::post('/papper/milike/{datos}', 'usuarioController@mylike');
    Route::post('/papper/milike/comentario/{datos}', 'usuarioController@mylike_comentarios');
    Route::get('/papper/grupos', 'usuarioController@grupos');
    Route::get('/papper/logout', 'usuarioController@logout');
    Route::get('/papper/notificaciones', 'usuarioController@notificaciones');
    Route::post('/papper/preguntas/save/logs', 'usuarioController@store');
    Route::post('/papper/filtrado/{grupo}/{palabra}', 'usuarioController@filtrado');
});
// Route::get('/papper/like/{datos}/{like}', 'usuarioController@likes');
// Route::get('/papper/preguntas/{grupo}', 'usuarioController@create');

Route::get('/papper/like/comentarios/{datos}/{like}', 'usuarioController@likes_comentarios');

