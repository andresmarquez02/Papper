<?php

use Illuminate\Support\Facades\Route;

// Ruta inicial
Route::get('/', 'HomeController@index');
//Rutas para l ver publicaciones y busquedas de ellas
Route::get('posts', 'PostController@posts');
Route::get('posts/populars', 'PostController@postsPopulars');
Route::get('posts/recommends', 'PostController@postsRecommends');
Route::get('posts/{category}', 'PostController@postsByCategory');
Route::get('posts/search/{category}/{query}', 'PostController@searchPosts');

// Comentarios
Route::get('commentaries/{id}', 'CommentaryController@commentaries');
// Categorias
Route::get('categories', 'HomeController@categories');

// Rutas solo para cuando no se este logueado
Route::middleware(['guest'])->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

Route::middleware(['auth'])->group(function () {
    //usuario y datos
    Route::post('user', 'UserController@user');
    Route::get('notifications', 'UserController@notifications');

    // Ver perfil de usuario
    Route::get('profile/{username}', 'PostController@profileUser');

    //posts
    Route::post('create/post', 'PostController@createPost');
    Route::put('update/post/{id}', 'PostController@updatePost');
    Route::delete('delete/post/{id}', 'PostController@deletePost');
    Route::post('reacted/{postId}', 'PostController@reactedPost');

    // Denuncias a posts
    Route::get('denunciations', 'PostController@denunciations');
    Route::post('denuncied/post/{id}', 'PostController@denunciedPost');

    //Comentarios
    Route::post('create/commentary/{id}', 'CommentaryController@saveCommentary');
    Route::post('reacted/commentary/{commentaryId}', 'CommentaryController@reactionCommentaries');
    Route::post('delete/commentary/{id}', 'CommentaryController@deleteCommentary');
    // Route::post('update/commentary/{id}', 'CommentaryController@updateCommentary');

    // RUTAS ADMIN
    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::resource('denunciations', DenunciationController::class);
            Route::get('posts/denuncied', 'PostController@postsDenuncied');
            Route::get('denunciations/post/{id}', 'PostController@denunciationsPost');
            Route::post('close/post/{id}', 'PostController@closePost');
            Route::get('users', 'UserController@users');
            Route::get('change/status/account/{id}', 'UserController@changeStatusAccount');
        });
    });
    // Desloguearme
    Route::get('logout', 'AuthController@logout');
});

