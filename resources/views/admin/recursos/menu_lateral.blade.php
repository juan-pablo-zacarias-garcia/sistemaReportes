<!-- Include mmenu files -->


<!DOCTYPE html>
<html>

<head>

    <title>Menu Administrador</title>
    <meta charset="utf-8" />

    <!-- Include mmenu files -->
    <link rel="stylesheet" href="{{asset('assets/css/mmenu.css')}}" />
    <script src="{{asset('assets/js/mmenu.js')}}"></script>

    <!-- Fire the plugin -->
    <script>
    document.addEventListener(
        "DOMContentLoaded", () => {
            new Mmenu("#menu", {
                "offCanvas": {
                    "position": "left"
                },
                "theme": "light"
            });
        }
    );
    </script>
</head>

<body>
    <!-- The menu -->
    <nav id="menu">
        <ul>
            <li><a href="/"><img src="{{asset('assets/img/agricola_nieto.png')}}" class="rounded mx-auto d-block"
                        width="50%" alt="AgricolaNieto"></a></li>
            <li><span>{{ Auth::user()->name }}</span></li>
            <li><a href="{{route('viewUsuarios')}}">Usuarios</a></li>
            <li><a href="{{route('profile.edit')}}">Mi cuenta</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Salir') }}
                    </x-dropdown-link>
                </form>
            </li>
        </ul>
    </nav>

</body>

</html>