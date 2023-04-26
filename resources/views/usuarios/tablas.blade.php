<x-app-layout>
    @if (Auth::user()->type==2)
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/keyTable.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/searchPanes.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-multiselect.css')}}" />
    <div class="col-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto col-12 ">
                <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="col-12 ">
                        <h3 id="tablas_titulo">Tablas disponibles</h3>
                        <hr>
                        <div id="filtros">
                            <label class="">Año:
                                <select id="selectAnio" onChange="selectAnio()">
                                    <option selected="true" disabled="disabled">Seleccione año</option>
                                    @foreach ($anios as $anio)
                                    <option value="{{$anio->ANIO}}">{{$anio->ANIO}}</option>
                                    @endforeach
                                    <!-- <option value="0">Todos</option> -->
                                </select></label>

                            <label id="OptselectMes" class="hidden">Mes:
                                <select id="selectMes" multiple="multiple" onChange="selectMes()">

                                </select></label>
                            <label id="OptselectSemana" class="hidden" onChange="selectSemana()">Semana:
                                <select id="selectSemana" multiple="multiple">

                                </select></label>
                        </div>
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
                                <li class="nav-item">
                                    <a id="9" type="button" onclick="cargaTabla('9','graficas');" href="#"
                                        class="nav-link">
                                        Gráficas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto col-12 ">
                            <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="col-12 ">
                                    <div id="pricipal" style="background-color:white;">
                                        <!-- Se agregan la tabla seleccionada con js -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.keyTable.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.searchPanes.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/bootstrap-multiselect.js')}}"></script>
        <script type="text/javascript">
        activo = '1';
        var anio;
        var selectedMeses;
        var selectedSemanas;

        // Funciones para filtrado
        function selectAnio() {
            anio = $('#selectAnio').val();
            $("#listaTablas").removeClass("hidden");
            $("#tablas_titulo").empty();
            $("#tablas_titulo").append("Tablas disponibles " + (anio == '0' ? 'de todos los años' :
                anio));
            $("#pricipal").empty();
            //ajax para recuperar los meses del año seleccionado
            $.ajax({
                url: "/getMeses/" + anio,
                type: "GET",
                success: function(data){
                    meses = data;
                    cargarMeses(meses);
                    $("#OptselectMes").removeClass("hidden");
                    //recuperamos los meses seleccionados
                    select = document.getElementById('selectMes');
                    selectedMeses = Array.from(select.selectedOptions, option => option.value);
                },
                error:function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }

        //función para cargar el arreglo de meses en el select
        function cargarMeses(meses){
            //cargamos los meses
            //primero destruimos el select
            $('#selectMes').multiselect('destroy');
            //quitamos las opciones del select
            $('#selectMes').empty();
            //Agregamos las nuevas opciones
            for(i=0; i<meses.length; i++){
                $('#selectMes').append("<option value='"+meses[i].MES+"' selected>"+meses[i].MES+"</option>");
            }
            //contruimos el select multiple con su configuracion
            $('#selectMes').multiselect({
                includeSelectAllOption: true,
                maxHeight: 450
                
            });
            
            selectMes();
        }

        //Carga las semanas disponibles de los meses seleccionados
        function selectMes() {
            //recuperamos los meses seleccionados
            select = document.getElementById('selectMes');
            selectedMeses = Array.from(select.selectedOptions, option => option.value);
            
            //Limpiamos el div principal
            $("#pricipal").empty();

            //configuramos el token
            //Se configura ajax para que mande el token csrf
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //creamos la variable para guardar los datos del formulario
            let formData = new FormData();
             //se agrega al formData la lista de meses y el año
             formData.append('meses', selectedMeses);
             formData.append('anio', anio);
            //ajax para recuperar las semanas del mes seleccionado
            $.ajax({
                url: "{{ route('getSemanas') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    semanas = data;
                    cargaSemanas(semanas);
                    $("#OptselectSemana").removeClass("hidden");
                    //recuperramos las semanas seleccionadas
                    select = document.getElementById('selectSemana');
                    selectedSemanas = Array.from(select.selectedOptions, option => option.value);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }

        //carga las semanas en el select
        function cargaSemanas(semanas){
            //cargamos las semanas
            //primero destruimos el select
            $('#selectSemana').multiselect('destroy');
            //quitamos las opciones del select
            $('#selectSemana').empty();
            //Agregamos las nuevas opciones
            for(i=0; i<semanas.length; i++){
                $('#selectSemana').append("<option value='"+semanas[i].SEMANA+"' selected>"+semanas[i].SEMANA+"</option>");
            }
            //contruimos el select multiple con su configuracion
            $('#selectSemana').multiselect({
                includeSelectAllOption: true,
                maxHeight: 450
            });
            selectSemana();
        }

        function selectSemana() {
            //recuperramos las semanas seleccionadas
            select = document.getElementById('selectSemana');
            selectedSemanas = Array.from(select.selectedOptions, option => option.value);
            //Limpiamos el div principal
            $("#pricipal").empty();
        }

        // Termina parte de filtrado

        function cargaTabla(item, tabla) {

             //creamos la variable para guardar los datos del formulario
             let formData = new FormData();
             //se agrega al formData la lista de meses
             formData.append('anio', anio);
             //se agrega al formData la lista de meses
             formData.append('meses', selectedMeses);
             //se agrega al form data la lista de semanas
             formData.append('semanas', selectedSemanas);


            //Se configura ajax para que mande el token csrf
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //cargamos la tabla seleccionada con ajax
            tbl = $.ajax({
                url: "/" + tabla,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#' + activo).removeClass("active");
                    $("#" + item).addClass("active");
                    activo = item;
                    $("#pricipal").empty();
                    $("#pricipal").append("<div class=''>Cargando...</div>");
                },
                error: function(response) {
                    $('#' + activo).removeClass("active");
                    $("#" + item).addClass("active");
                    activo = item;
                    $("#pricipal").empty();
                    $("#pricipal").append("<div class='text-danger'>Error al cargar la información</div>");
                    console.log(response.responseJSON.message);
                }
            }).done(function() {
                MostrarTabla(item, tbl);
            });
        }
        //muestra la tabla seleccionada
        function MostrarTabla(choosen, tabla) {
            //limpia el div principal
            $("#pricipal").empty();
            //agrega la tabla devuelta por la petición AJAX
            $("#pricipal").append(tabla.responseText);
            //cambia el item seleccionado
            activo = choosen;
        }

        $(document).ready(function() {
            $('#selectAnio').multiselect();
        });
        </script>
        @else
        <h1>Acceso denegado</h1>
        @endif
</x-app-layout>