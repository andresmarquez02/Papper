<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pagina no encontrada</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/papper.css')}}">
</head>
<body style="overflow-x: hidden">
    <div class="w-100 vh-100 d-flex justify-content-center align-items-center">
        <div class="w-md-85 w-95">
            <h1 class="display-1 font-weight-bold text-center text-error">500</h1>
            <h1 class="font-weight-bold text-center">OOPPS!! <br> Ha ocurrido un error inesperado</h1>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary btn-lg rounded-pill shadow-sm" href="{{url('/')}}" role="button">Ir al inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
