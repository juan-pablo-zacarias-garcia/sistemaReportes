<br />
<br />
<h4>Resultados por cultivo</h4>
<hr>
<table id="tablaResultadosXCultivo" class="table table-bordered table-condensed table-striped col-md-8">
    <thead>
        <tr>
            @foreach ($headers as $header)
            <th>{{$header}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $fila)
        <tr>
            @foreach($fila as $dato)
            <td>{{$dato==0?'':(is_numeric($dato)?'$ '.number_format($dato, 2):$dato)}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
<!-- La API de DATATABLE nos permite realizar operaciones con los datos de la tabla -->
<script src="{{asset('assets/js/sum().js')}}"></script>
<script type="text/javascript">
var tablaResultadosXCultivo;
$(document).ready(
    function() {

        // Si existe una instancia condatatable la eliminamos para poder reiniciarla
        $('#tablaResultadosXCultivo').dataTable().fnDestroy();

        tablaResultadosXCultivo = $('#tablaResultadosXCultivo').DataTable({
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
            select: true,
            keys: true
        });

        // Agregamos la ultima fila de totales
        const filatotales = ['Total:'];
        //Funcion para formatear los datos
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        })

        //agregamos la fila de totales
        // for (var i = 1; i < tablaRendimientoXHa.columns().count(); i++) {
        //     filatotales.push(tablaRendimientoXHa.column(i).data().sum());
        // }
        // fila = tablaRendimientoXHa.row.add(filatotales).draw(false);
    }
);
</script>