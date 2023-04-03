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
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" />
</head>

<body class="font-sans antialiased">
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
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

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
<script type="text/javascript">
var minutos = 0;
$(document).ready(function() {
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