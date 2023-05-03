<x-app-layout>
    @if (Auth::user()->type==env('USER_COMUN'))
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/keyTable.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/searchPanes.dataTables.min.css')}}" />
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.searchPanes.min.js')}}"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto col-12 ">
            <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="col-12 ">
                    <div style="background-color:white;">
                        <button class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                        <br />
                        <br />
                        <h4>Detalle</h4>
                        <hr>
                        <table id="tablaDetalle" class="table table-bordered table-condensed table-striped hidden"
                            width="100%">
                            <thead>
                                <tr>
                                    @foreach ($headers as $header)
                                    <th>{{$header}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos as $fila)
                                <!-- Se reinicia el puntero que recorre el arreglo $datos[0] -->
                                @php
                                reset($datos[0]);
                                @endphp
                                <tr>
                                    @foreach($fila as $dato)
                                    <td>
                                        @if(key($datos[0])=='DETALLE')
                                        <input id="ANIO" value="{{$fila->AÑO}}" type="hidden" />
                                        <input id="MES" value="{{$fila->MES}}" type="hidden" />
                                        <input id="SEMANA" value="{{$fila->SEMANA}}" type="hidden" />
                                        <input id="CODIGO" value="{{$fila->CODIGO}}" type="hidden" />
                                        <input class="alert-link" type="submit" value="{{$dato}}" onclick="detalle()" />
                                        @else
                                        {{($dato=='$0.00' || $dato==0)?'':$dato}}
                                        @endif
                                    </td>
                                    <!-- Pasamos a la próxima llave del arreglo datos[0] -->
                                    @php
                                    next($datos[0]);
                                    @endphp
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(
        function() {
            setTimeout(() => {
                //hacemos clic en el header
                $('th').click();
            }, 50);
        }
    );
    </script>

    <script type="text/javascript">
    var tablaDetalle;
    $(document).ready(
        function() {
            // Si existe una instancia condatatable la eliminamos para poder reiniciarla
            $('#tablaDetalle').dataTable().fnDestroy();
            $('#tablaDetalle').removeClass('hidden');
            tablaDetalle = $('#tablaDetalle').DataTable({
                'iDisplayLength': 25,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total Filas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Filas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                dom: 'Plfrtip',
                searchPanes: {
                    initCollapsed: true,
                    columns: [4, 7],
                    dtOpts: {
                        select: {
                            style: 'multi'
                        }
                    }
                },
                scrollX: true,
                scrollY: 400,
                select: true,
                keys: true
            });
        }
    );

    function detalle() {

    }
    </script>

    @else
    <h1>Acceso denegado</h1>
    @endif

</x-app-layout>