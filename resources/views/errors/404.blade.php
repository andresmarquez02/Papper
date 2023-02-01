@extends('layout.app')
@section('content')
    <div style="overflow-x: hidden">
        <div class="m-0 w-100 vh-100 d-flex justify-content-center align-items-center row bg-font">
            <div class="col-md-5">
                <h1 class="mb-1 text-center text-white font-weight-bold display-3">404</h1>
                <h1 class="text-center text-white font-weight-bold display-4">Uppsss...</h1>
                <h1 class="text-center text-white font-weight-bold">La pagina que buscas no esta disponible.</h1>
                <div class="mt-3 d-flex justify-content-center">
                    <div class="mt-3 d-flex justify-content-center">
                        <a class="shadow-sm btn btn-light btn-lg rounded-pill waves-effect" href="{{ url("/") }}">Ir al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
