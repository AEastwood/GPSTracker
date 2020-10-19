<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name') }} :: Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="These buttons examples contain icons with or without labels attached.">

    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <link href="{{ asset('css/architect.css') }}" rel="stylesheet">
    @auth
    @endauth
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        @component('components.navbar')
        @endcomponent
        <main class="" style="padding-top: 55px;">
        @yield('content')
        </main>
    </div>
    <div class="app-drawer-overlay d-none animated fadeIn "></div>
    <script type="text/javascript " src="{{ asset( 'js/home.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
