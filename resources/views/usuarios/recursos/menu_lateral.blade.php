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
                    @php
                    $departments = DB::select("select * from departments where id=".Auth::user()->department);
                    @endphp
                    @foreach( $departments as $department)
                    @if($department->status==1)
                    <li><a>
                            <form method="POST" action="{{route('documentos',['department'=>$department->name])}}">
                                @csrf
                                <input class="w-100" name="{{$department->name}}" type="submit"
                                    value="{{$department->name}}">
                            </form>
                        </a>
                    </li>
                    @else
                    <li><a>Departamento cerrado</a></li>
                    @endif
                    @endforeach
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