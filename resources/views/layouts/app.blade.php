<?php 

use App\Http\Controllers\MapController;

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @auth
    <title>{{ config('app.name') }} :: Map</title>
    @else
    <title>{{ config('app.name') }}</title>
    @endauth
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="These buttons examples contain icons with or without labels attached.">

    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>    
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>    
    <link href="{{ asset('css/architect.css') }}" rel="stylesheet">
    @auth
    @if(Request::route()->getName() == 'map')
    <link href="{{ asset('css/map.css') }}?{{rand(0, getrandmax()) }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}?{{rand(0, getrandmax()) }}" rel="stylesheet">
    <script src="{{ asset('js/map.js') }}?{{rand(0, getrandmax()) }}"></script>
    <script src="{{ asset('js/mapthemes.js') }}?{{rand(0, getrandmax()) }}"></script>
    <script src="{{ asset('js/jscolor.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script type="text/javascript">
        var dangerzones = {{ Auth::user()->dangerzones }},
            map_mode = {{ Auth::user()->map_mode }},
            userStyle = {{ Auth::user()->theme }};
        </script>
    @endif
    @endauth
</head>

<body>
    @CSRF
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        @component('components.navbar')
        @endcomponent
        <main class="" style="padding-top: 55px;">
            @auth
                @yield('map')
            @else
                @yield('content')
            @endauth
        </main>
    </div>
    <div class="app-drawer-overlay d-none animated fadeIn "></div>
    <script type="text/javascript " src="{{ asset( 'js/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
    @auth
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('app.apikey') }}&libraries=drawing,geometry&callback=AppStart"></script>
    @endauth
</body>
</html>