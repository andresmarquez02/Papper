<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="token" content="{{csrf_token()}}">
    <title>Papper</title>
    <link rel="shortcut icon" href="{{asset("img/logo.png")}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/papper.css')}}">
</head>
    <body class="bg-white" style="overflow-x:hidden">
        @yield('content')
        {{-- Spinner de carga --}}
        <div id="carga" class="loading-backdrop d-none bg-black-30 justify-content-center align-items-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('alertify/alertify.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>

