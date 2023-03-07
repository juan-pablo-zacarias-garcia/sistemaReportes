<br/>
<br/>
<h4>Horizontal</h4>
<hr>
<table id="tablaHorizontal" class="table table-bordered table-condensed table-striped col-md-8">
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
            <td>{{$dato==0?'':$dato}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
<!-- La API de DATATABLE nos permite realizar operaciones con los datos de la tabla -->
<script src="{{asset('assets/js/sum().js')}}"></script>
<script type="text/javascript">
var tablaHorizontal;
$(document).ready(
    function() {

        tablaHorizontal = $('#tablaHorizontal').DataTable({
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

        

        //agregamos la fila de totales
        // for (var i = 1; i < tablaVentasXHa.columns().count(); i++) {
        //     filatotales.push(formatter.format(tablaVentasXHa.column(i).data().sum()));
        // }
        // fila = tablaVentasXHa.row.add(filatotales).draw(false);
    }
);
</script>