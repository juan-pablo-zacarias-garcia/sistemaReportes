<br />
<br />
<h4>Horizontal</h4>
<hr>
<table id="tablaHorizontal" class="table table-bordered table-condensed table-striped hidden" width="100%">
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
            <td>{{($dato=='$0.00' || $dato==0)?'':$dato}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
var tablaHorizontal;
$(document).ready(
    function() {
        // Si existe una instancia condatatable la eliminamos para poder reiniciarla
        $('#tablaHorizontal').dataTable().fnDestroy();
        $('#tablaHorizontal').removeClass('hidden');
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
</script>