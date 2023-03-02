<x-app-layout>
    @if (Auth::user()->type==1)
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/keyTable.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/searchPanes.dataTables.min.css')}}" />

    <div class="flex">
        <div class="col-12">
            <div class="py-12">
                <div class="max-w-7xl mx-auto col-12 ">
                    <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="col-12">
                            <h3>Tablas disponibles</h3>
                            <hr>
                            <a id="0" type="button" href="#thl" class="btn btn-outline-danger col-md-2 m-1">Todas las tablas</a>
                            <a id="1" type="button" href="#thl" class="btn btn-outline-danger col-md-2 m-1">Horizontal</a>
                            <a id="2" type="button" href="#tcxh" class="btn btn-outline-danger col-md-2 m-1"> Costos por hectarea</a>
                            <a id="3" type="button" href="#tvxh" class="btn btn-outline-danger col-md-2 m-1"> Ventas por hectarea</a>
                            <a id="4" type="button" href="#" class="btn btn-outline-danger col-md-2 m-1"> Rendimiento por hectarea</a>
                            <a id="5" type="button" href="#" class="btn btn-outline-danger col-md-2 m-1"> Resultados por cultivo</a>
                            <a id="6" type="button" href="#" class="btn btn-outline-danger col-md-2 m-1"> Agroquímicos por hectarea</a>
                            <a id="7" type="button" href="#" class="btn btn-outline-danger col-md-2 m-1"> Fertilizantes por hectarea</a>
                            <a id="8" type="button" href="#" class="btn btn-outline-danger col-md-2 m-1"> Plántula por hectarea</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-12" id="thl">
                <div class="max-w-7xl mx-auto col-12 ">
                    <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="col-md-12 ">
                            <h3>Horizontal</h3>
                            <hr>
                            <div id="divHorizontal">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-12" id="tcxh">
                <div class="max-w-7xl mx-auto col-md-12 ">
                    <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="col-12 ">
                            <h3>Costos por Hectarea</h3>
                            <hr>
                            <div id="divCostosXHa">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-12" id="tvxh">
                <div class="max-w-7xl mx-auto col-md-12 ">
                    <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="col-12 ">
                            <h3>Ventas por Hectarea</h3>
                            <hr>
                            <div id="divVentasXHa">

                            </div>
                        </div>
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
    $("#divHorizontal").load('/tablaHorizontal');
    //cargamos la tabla de costos por hectarea
    $("#divCostosXHa").load('/tablaCostoXHa');
    //cargamos la tabla de ventas por hectarea
    $("#divVentasXHa").load('/tablaVentasXHa');
    </script>
    @else
    <h1>Acceso denegado</h1>
    @endif

</x-app-layout>