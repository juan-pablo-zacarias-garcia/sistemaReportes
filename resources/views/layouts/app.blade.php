<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agrícola Nieto') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
</head>

<body class="font-sans antialiased">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <div id="navbar" class="hidden">
        <!-- Barra de navegación para cada tipo de usuario-->
        @switch(Auth::user()->type)
        @case(env('USER_ADMIN'))
        @include('admin.recursos.navbar_admin')
        @include('admin.recursos.menu_lateral')
        @break
        @case(env('USER_COMUN'))
        @include('usuarios.recursos.navbar_user')
        @include('usuarios.recursos.menu_lateral')
        @break
        @endswitch
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <div class="pt-4">
        <div class="col-12 text-white" style="position: absolute; bottom:0; background-color:gray;">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top">
                <div class="col-md-4 d-flex align-items-center">
                    <span class="mb-3 ml-4 mb-md-0 text-body-secondary">Agrícola Nieto S. de P.R. de R.L. de C.V.</span>
                </div>
            </footer>
        </div>
    </div>
</body>
<script type="text/javascript">
var minutos = 0;
$(document).ready(function() {
    //muestra ya cargada la barra de navegación y el menú
    $("#navbar").removeClass("hidden");
    //incrementa minutos 
    var idleInterval = setInterval(timerIncrement, 60000);
    // 1 minuto
    //Si hay actividad reinicia el timmer 
    $(this).mousemove(function(e) {
        minutos = 0;
    });
    $(this).keypress(function(e) {
        minutos = 0;
    });
});

function timerIncrement() {
    minutos = minutos + 1;
    if (minutos > 5) {
        //Después de 5 minutos hace logout
        document.getElementById('logout-form').submit();
    }
}
</script>

</html>