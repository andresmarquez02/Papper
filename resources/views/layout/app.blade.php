<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="token" content="{{csrf_token()}}">
    <title>Papper</title>
    {{-- Esto esta asi por fallos en el https y http --}}
    @if (env('APP_ENV') == "production")
        <link rel="shortcut icon" href="{{secure_asset("Papper.png")}}">
        <link rel="stylesheet" href="{{secure_asset('css/app.css')}}">
        <link rel="stylesheet" href="{{secure_asset('css/papper.css')}}">
    @else
        <link rel="shortcut icon" href="{{asset("Papper.png")}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/papper.css')}}">
    @endif
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
</head>
    <body class="bg-white">
        @yield('content')
        {{-- Spinner de carga --}}
        <div id="carga" class="modal-backdrop d-none bg-black-30 justify-content-center align-items-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
        </div>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('alertify/lib/alertify.min.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        @yield('script')
    </body>
</html>
