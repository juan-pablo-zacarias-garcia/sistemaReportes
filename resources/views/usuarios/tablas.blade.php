<x-app-layout>
    @if (Auth::user()->isAdmin==0)
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/keyTable.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/searchPanes.dataTables.min.css')}}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12 space-y-12">
            <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="col-md-12 ">
                    <h3>Tablas</h3>
                    <hr>
                    <div id="tablaHorizontal">

                    </div>


                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.searchPanes.min.js')}}"></script>
    <script type="text/javascript">
    //cargamos la tabla de los usuarios
    $("#tablaHorizontal").load('/tablaHorizontal');
    </script>
    @else
    <h1>Acceso denegado</h1>
    @endif

</x-app-layout>