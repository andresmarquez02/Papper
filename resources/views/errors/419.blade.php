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
    <div class="w-100 vh-100 d-flex justify-content-center align-items-center row m-0">
        <div class="col-md-5">
            <h1 class="display-1 font-weight-bold text-center">Pagina no Encontrads</h1>
            <div class="d-flex justify-content-center">
                <a class="btn btn-danger btn-lg rounded-pill shadow-sm" href="{{url('/')}}" role="button">Ir al inicio</a>
            </div>
        </div>
        <div class="col-md-7">
            <img src="{{asset('img/Error_404_SVG.svg')}}" class="w-100" style="height: 59vh;transform: rotate(347deg);" srcset="">
        </div>
    </div>
</body>
</html>
