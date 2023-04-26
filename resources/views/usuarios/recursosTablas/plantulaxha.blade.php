<br />
<br />
<h4>Plántula por hectarea</h4>
<hr>
<table id="tablaPlantulaXHa" class="table table-bordered table-condensed table-striped">
    <thead>
        <tr>
            @foreach ($headers as $header)
            <th>{{$header}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    <!-- Datos para la tabla -->
    @foreach($datos as $fila)
        <!-- Se reinicia el puntero que recorre el arreglo $datos[0] -->
        @php
        reset($datos[0]);
        @endphp
        <tr>
            @foreach($fila as $dato)
            <td>
                <!-- Si la llave del dato del arreglo es igual a producto entonces es la columna PRODUCTO y solo se imprime el valor, y no el formulario-->
                @if(key($datos[0])=='PRODUCTO')
                {{$dato}}
                @else
                <!-- Si el dato es $0.00 no imprime nada en el td, d elo contrario imprime el dato como un formulario para ver los detalles-->
                    @if($dato!='$0.00')
                    <form method="POST" action="{{ route('detallesTablas') }}">
                        @csrf
                        <input name="cols" type="hidden" value="{{$cols}}" />
                        <input name="anio" type="hidden" value="{{$anio}}" />
                        <input name="meses" type="hidden" value="{{$meses}}" />
                        <input name="semanas" type="hidden" value="{{$semanas}}" />
                        <input name="producto" type="hidden" value="{{$fila->PRODUCTO}}" />
                        <input name="rancho" type="hidden" value="{{key($datos[0])}}" />
                        <input class="alert-link" type="submit" value="{{$dato}}" />
                    </form>
                    @endif
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
<br />
<br />
<h4>Promedio de plántula por hectarea</h4>
<hr>
<table id="tablaPlantulaPromedioXHa" class="table table-bordered table-condensed table-striped">
    <thead>
        <tr>
            @foreach ($headers2 as $header)
            <th>{{$header}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    <!-- Reinicia el puntero de la KEY del arreglo, es la que dice el nombre de la columna -->
    @foreach($datos2 as $fila)
        @php
        reset($datos2[0]);
        @endphp
        <tr>
            @foreach($fila as $dato)
            <td>
                <!-- Si la columna es la de PRODUCTO entonces solo agrega el dato, no el formulario -->
            @if(key($datos2[0])=='PRODUCTO')
                {{$dato}}
            @else
            <!-- Si el dato es diferente de cero entonces muestra el dato con un formulario para ver los detalles -->
                @if($dato!='$0.00')
                <form method="POST" action="{{ route('detallesTablas') }}">
                    @csrf
                    <input name="cols" type="hidden" value="{{$cols}}" />
                    <input name="anio" type="hidden" value="{{$anio}}" />
                    <input name="meses" type="hidden" value="{{$meses}}" />
                    <input name="semanas" type="hidden" value="{{$semanas}}" />
                    <input name="producto" type="hidden" value="{{$fila->PRODUCTO}}" />
                    <input name="rancho" type="hidden" value="all" />
                    <input class="alert-link" type="submit"
                        value="{{$dato}}" />
                </form>
                @endif
            @endif
            </td>
            <!-- Pasa a la siguiente llave del arreglo -->
            @php
            next($datos2[0]);
            @endphp
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>


<script type="text/javascript">
$(document).ready(
    function() {
        // Si existe una instancia condatatable la eliminamos para poder reiniciarla
        $('#tablaPlantulaXHa').dataTable().fnDestroy();

        tablaPlantulaXHa = $('#tablaPlantulaXHa').DataTable({
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
            scrollX: true,
            scrollY: 400,
            select: false,
            keys: true
        });
        // Si existe una instancia condatatable la eliminamos para poder reiniciarla
        $('#tablaPlantulaPromedioXHa').dataTable().fnDestroy();

        tablaPlantulaPromedioXHa = $('#tablaPlantulaPromedioXHa').DataTable({
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
            scrollX: true,
            scrollY: 400,
            select: false,
            keys: true
        });
    }
);
</script>