<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="token" content="{{csrf_token()}}">
    <title>Papper</title>
    @if (env('APP_ENV') == "production")
    <link rel="shortcut icon" href="{{asset("Papper.png")}}">
    <link rel="stylesheet" href="{{secure_asset('css/app.css')}}">
    <link rel="stylesheet" href="{{secure_asset('css/papper.css')}}">
    <link rel="stylesheet" href="{{secure_asset('alertify/themes/alertify.bootstrap-papper.css')}}">
    <link rel="stylesheet" href="{{secure_asset('alertify/themes/alertify.core-papper.css')}}">
    <link rel="stylesheet" href="{{secure_asset('alertify/themes/alertify.default-papper.css')}}">
    <link rel="stylesheet" href="{{secure_asset('assets/fontawesome-free-5.15.1-web/css/all.css')}}">
    <link rel="stylesheet" href="{{secure_asset('assets/fontawesome-free-5.15.1-web/css/solid.css')}}">
    <link rel="stylesheet" href="{{secure_asset('assets/fontawesome-free-5.15.1-web/css/v4-shims.css')}}">
    <link rel="stylesheet" href="{{secure_asset('assets/fontawesome-free-5.15.1-web/css/brands.css')}}">
        @else
        <link rel="shortcut icon" href="{{asset("Papper.png")}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/papper.css')}}">
        <link rel="stylesheet" href="{{asset('alertify/themes/alertify.bootstrap-papper.css')}}">
        <link rel="stylesheet" href="{{asset('alertify/themes/alertify.core-papper.css')}}">
        <link rel="stylesheet" href="{{asset('alertify/themes/alertify.default-papper.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/all.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/solid.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/v4-shims.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.15.1-web/css/brands.css')}}">
    @endif
</head>
    @yield('content')
</html>
