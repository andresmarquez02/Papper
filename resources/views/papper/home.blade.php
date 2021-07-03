<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="token" content="{{csrf_token()}}">
    <title>Papper</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/papper.css')}}">
    <link rel="stylesheet" href="{{asset('alertify/themes/alertify.bootstrap-papper.css')}}">
    <link rel="stylesheet" href="{{asset('alertify/themes/alertify.core-papper.css')}}">
    <link rel="stylesheet" href="{{asset('alertify/themes/alertify.default-papper.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/regular.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/solid.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/svg-with-js.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/v4-shims.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/brands.css')}}">
</head>
<body class="bg-white">
    <div id="app">
        <papper-home />
    </div>
    <div id="carga" class="modal-backdrop d-none bg-black-30 justify-content-center align-items-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
    </div>
    <script src="{{asset('alertify/lib/alertify.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        let pre = document.getElementById('carga')
        document.addEventListener('Load', function(){
            pre.classList.remove('d-none');
            pre.classList.add('d-flex');
        });
        pre.classList.remove('d-flex');
        pre.classList.add('d-none');
    </script>
</body>
</html>
