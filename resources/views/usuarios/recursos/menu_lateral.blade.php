<!-- Include mmenu files -->


<!DOCTYPE html>
<html>

<head>

    <title>Menu Usuario</title>
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
            <li><a href="{{route('tablas')}}">Tablas</a></li>
            <li><span>Documentos</span>
                <ul>
                    <li><span>RH</span>
                        <ul>
                            <li><a href="#">Documento1</a></li>
                        </ul>
                    </li>
                    <li><span>Finanzas</span>
                        <ul>
                            <li><a href="#">Documento1</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><span>{{ Auth::user()->name }}</span>
                <ul>
                    <li><a href="{{route('profile.edit')}}">Mi cuenta</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

</body>

</html>