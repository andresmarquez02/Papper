<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentaryController;
use App\Http\Controllers\DenunciationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Ruta inicial
Route::view('/', 'index');
//Rutas para l ver publicaciones y busquedas de ellas
Route::get('posts', [PostController::class, 'posts']);
Route::get('posts/populars', [PostController::class, 'postsPopulars']);
Route::get('posts/recommends', [PostController::class, 'postsRecommends']);
Route::get('posts/{category}', [PostController::class, 'postsByCategory']);
Route::get('posts/search/{category}/{query}', [PostController::class, 'searchPosts']);

// Comentarios
Route::get('commentaries/{id}', [CommentaryController::class, 'commentaries']);
// Categorias
Route::get('categories', [HomeController::class, 'categories']);

// Rutas solo para cuando no se este logueado
Route::middleware(['guest'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    //usuario y datos
    Route::post('user', [UserController::class, 'user']);
    Route::get('notifications', [UserController::class, 'notifications']);

    // Ver perfil de usuario
    Route::get('profile/{username}', [PostController::class, 'profileUser']);

    //posts
    Route::post('create/post', [PostController::class, 'createPost']);
    Route::put('update/post/{id}', [PostController::class, 'updatePost']);
    Route::delete('delete/post/{id}', [PostController::class, 'deletePost']);
    Route::post('reacted/{postId}', [PostController::class, 'reactedPost']);

    // Denuncias a posts
    Route::get('denunciations', [PostController::class, 'denunciations']);
    Route::post('denuncied/post/{id}', [PostController::class, 'denunciedPost']);

    //Comentarios
    Route::post('create/commentary/{id}', [CommentaryController::class, 'saveCommentary']);
    Route::post('reacted/commentary/{commentaryId}', [CommentaryController::class, 'reactionCommentaries']);
    Route::post('delete/commentary/{id}', [CommentaryController::class, 'deleteCommentary']);
    // Route::post('update/commentary/{id}', [CommentaryController::class, 'updateCommentary']);

    // RUTAS ADMIN
    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::resource('denunciations', DenunciationController::class);
            Route::get('posts/denuncied', [PostController::class, 'postsDenuncied']);
            Route::get('denunciations/post/{id}', [PostController::class, 'denunciationsPost']);
            Route::post('close/post/{id}', [PostController::class, 'closePost']);
            Route::get('users', [UserController::class, 'users']);
            Route::get('change/status/account/{id}', [UserController::class, 'changeStatusAccount']);
        });
    });
    // Desloguearme
    Route::get('logout', [AuthController::class, 'logout']);
});

