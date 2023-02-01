<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\PreguntasRepositori;
use App\Http\Interfaces\PreguntasInterface;
use App\Http\Repositories\ComentariosRepositori;
use App\Http\Interfaces\ComentariosInterface;
use App\Http\Interfaces\CommentaryInterface;
use App\Http\Interfaces\PostInterface;
use App\Http\Repositories\CommentaryRepository;
use App\Http\Repositories\PostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
