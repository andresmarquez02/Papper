<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\PreguntasRepositori;
use App\Http\Interfaces\PreguntasInterface;
use App\Http\Repositories\ComentariosRepositori;
use App\Http\Interfaces\ComentariosInterface;

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
        $this->app->bind(PreguntasInterface::class, PreguntasRepositori::class);
        $this->app->bind(ComentariosInterface::class, ComentariosRepositori::class);
    }
}
