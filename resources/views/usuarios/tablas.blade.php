<x-app-layout>
    @if (Auth::user()->type==1)
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/keyTable.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/searchPanes.dataTables.min.css')}}" />


    <div class="col-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto col-12 ">
                <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="col-12">
                        <h3>Tablas disponibles</h3>
                        <hr>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a id="1" type="button" class="nav-link active">Horizontal</a>
                            </li>
                            <li class="nav-item">
                                <a id="2" type="button" class="nav-link">Costos por
                                    hectarea</a>
                            </li>
                            <li class="nav-item">
                                <a id="3" type="button" class="nav-link">
                                    Ventas por
                                    hectarea</a>
                            </li>
                            <li class="nav-item">
                                <a id="4" type="button" class="nav-link">
                                    Rendimiento
                                    por hectarea</a>
                            </li>
                            <li class="nav-item">
                                <a id="5" type="button" href="#" class="nav-link">
                                    Resultados por
                                    cultivo</a>
                            </li>
                            <li class="nav-item">
                                <a id="6" type="button" href="#" class="nav-link">
                                    Agroquímicos
                                    por hectarea</a>
                            </li>
                            <li class="nav-item">
                                <a id="7" type="button" href="#" class="nav-link">
                                    Fertilizantes
                                    por hectarea</a>
                            </li>
                            <li class="nav-item">
                                <a id="8" type="button" href="#" class="nav-link">
                                    Plántula por
                                    hectarea</a>
                            </li>
                            <li class="nav-item">
                                <a id="0" type="button" class="nav-link">Todas las
                                    tablas</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="pricipal">
                    <!-- Se agregan la tabla seleccionada con js -->
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
    $(document).ready(function() {


        ////Cargamos la tabla selecionada

        activo = '1';
        //cargamos la tabla horizontal
        thl = $.ajax({
            url: "/tablaHorizontal",
            type: "GET",
        });
        //cargamos la tabla de costos por hectarea
        tcxh = $.ajax({
            url: "/tablaCostoXHa",
            type: "GET",
        });
        //cargamos la tabla de ventas por hectarea
        tvxh = $.ajax({
            url: "/tablaVentasXHa",
            type: "GET",
        });
        //cargamos la tabla de rendimiento por hectarea
        trxh = $.ajax({
            url: "/tablaRendimientoXHa",
            type: "GET",
        });
        //cargamos la tabla de resultados por cultivo
        trxc = $.ajax({
            url: "/tablaResultadosXCultivo",
            type: "GET",
        });
        //cargamos la tabla de agroquímicos por hectarea
        taxh = $.ajax({
            url: "/tablaAgroquimicosXHa",
            type: "GET",
        });
        tfxh = $.ajax({
            url: "/tablaFertilizantesXHa",
            type: "GET",
        });

        tpxh = $.ajax({
            url: "/tablaPlantulaXHa",
            type: "GET",
        });

        //horizontal
        $("#1").click(function() {
            MostrarTabla('1', thl);
        });
        //tablaCostoXHa
        $("#2").click(function() {
            MostrarTabla('2', tcxh);
        });
        //tablaVentasXHa
        $("#3").click(function() {
            MostrarTabla('3', tvxh);
        });
        //tablaRendimientoXHa
        $("#4").click(function() {
            MostrarTabla('4', trxh);
        });
        //tablaResultadosXCultivo
        $("#5").click(function() {
            MostrarTabla('5', trxc);
        });
        //tablaResultadosXCultivo
        $("#6").click(function() {
            MostrarTabla('6', taxh);
        });
        //tablaFertilizantesXHa
        $("#7").click(function() {
            MostrarTabla('7', tfxh);
        });

        //tablaPlantulaXHa
        $("#8").click(function() {
            MostrarTabla('8', tpxh);
        });


        //Todas las tablas
        $("#0").click(function() {
            $("#pricipal").empty();
            $("#pricipal").append(thl.responseText);
            $("#pricipal").append(tcxh.responseText);
            $("#pricipal").append(tvxh.responseText);
            $("#pricipal").append(trxh.responseText);
            $("#pricipal").append(trxc.responseText);
            $("#pricipal").append(taxh.responseText);
            $("#pricipal").append(tfxh.responseText);
            $("#pricipal").append(tpxh.responseText);

            $('#' + activo).removeClass("active");
            $("#0").addClass("active");
            activo = "0";
        });

        function MostrarTabla(choosen, tabla) {
            $('#' + activo).removeClass("active");
            $("#pricipal").empty();
            $("#" + choosen).addClass("active");
            $("#pricipal").append(tabla.responseText);
            activo = choosen;
        }

    });
    </script>
    @else
    <h1>Acceso denegado</h1>
    @endif

</x-app-layout>