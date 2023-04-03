<x-app-layout>
    @if (Auth::user()->type==2)
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/keyTable.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/searchPanes.dataTables.min.css')}}" />


    <div class="col-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto col-12 ">
                <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="col-12 ">
                        <h3 id="tablas_titulo">Tablas disponibles</h3>
                        <hr>
                        <label>Año:
                            <select id="selectAnio" class="">
                                @foreach ($anios as $anio)
                                <option value="{{$anio->ANIO}}">{{$anio->ANIO}}</option>
                                @endforeach
                                <option value="0">Todos</option>
                            </select></label>
                        <button id="btnCargarTablas" class="btn btn-danger">Cargar tablas</button>
                        <hr>
                        <div id="listaTablas" class="hidden">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a id="1" type="button" onclick="cargaTabla('1','tablaHorizontal');"
                                        class="nav-link active">Horizontal</a>
                                </li>
                                <li class="nav-item">
                                    <a id="2" type="button" onclick="cargaTabla('2','tablaCostoXHa');"
                                        class="nav-link">Costos por
                                        hectarea</a>
                                </li>
                                <li class="nav-item">
                                    <a id="3" type="button" onclick="cargaTabla('3','tablaVentasXHa');"
                                        class="nav-link">
                                        Ventas por
                                        hectarea</a>
                                </li>
                                <li class="nav-item">
                                    <a id="4" type="button" onclick="cargaTabla('4','tablaRendimientoXHa');"
                                        class="nav-link">
                                        Rendimiento
                                        por hectarea</a>
                                </li>
                                <li class="nav-item">
                                    <a id="5" type="button" onclick="cargaTabla('5','tablaResultadosXCultivo');"
                                        href="#" class="nav-link">
                                        Resultados por
                                        cultivo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="6" type="button" onclick="cargaTabla('6','tablaAgroquimicosXHa');" href="#"
                                        class="nav-link">
                                        Agroquímicos
                                        por hectarea</a>
                                </li>
                                <li class="nav-item">
                                    <a id="7" type="button" onclick="cargaTabla('7','tablaFertilizantesXHa');" href="#"
                                        class="nav-link">
                                        Fertilizantes
                                        por hectarea</a>
                                </li>
                                <li class="nav-item">
                                    <a id="8" type="button" onclick="cargaTabla('8','tablaPlantulaXHa');" href="#"
                                        class="nav-link">
                                        Plántula por
                                        hectarea</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="pricipal" style="background-color:white;">
                    <!-- Se agregan la tabla seleccionada con js -->
                </div>
            </div>
        </div>

    </div>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.searchPanes.min.js')}}"></script>
    <script type="text/javascript">
    activo = '1';
    var anio;
    $(document).ready(function() {

        $("#btnCargarTablas").click(
            function() {
                anio = $('#selectAnio').val();
                $("#listaTablas").removeClass("hidden");
                $("#tablas_titulo").empty();
                $("#tablas_titulo").append("Tablas disponibles "+(anio=='0'?'de todos los años':anio));
                $("#pricipal").empty();
            }
        );

    });

    function cargaTabla(item, tabla) {
        //cargamos la tabla horizontal
        tbl = $.ajax({
            url: "/" + tabla + "/" + anio,
            type: "GET",
            beforeSend: function() {
                $('#' + activo).removeClass("active");
                $("#" + item).addClass("active");
                activo = item;
                $("#pricipal").empty();
                $("#pricipal").append("<div class=''>Cargando...</div>");
            },
            error: function() {
                $('#' + activo).removeClass("active");
                $("#" + item).addClass("active");
                activo = item;
                $("#pricipal").empty();
                $("#pricipal").append("<div class='text-danger'>Error al cargar la información</div>");
            }
        }).done(function() {
            MostrarTabla(item, tbl);
        });
    }

    function MostrarTabla(choosen, tabla) {
        $("#pricipal").empty();
        $("#pricipal").append(tabla.responseText);
        activo = choosen;
    }
    </script>
    @else
    <h1>Acceso denegado</h1>
    @endif

</x-app-layout>