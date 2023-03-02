<table id="tablas" class="table table-bordered table-condensed table-striped col-md-6">
    <thead>
        <tr>
            <th>MES</th>
            <th>SEMANA</th>
            <th>TABLA</th>
            <th>PRODUCTO</th>
            <th>CODIGO</th>
            <th>HECTAREAS</th>
            <th>RANCHO</th>
            <th>OBSERVACIONES</th>
            <th>REND_KG_X_HA</th>
            <th>KGS_TOTALES</th>
            <th>PLANTULA1</th>
            <th>AGROQUIMICOS1</th>
            <th>FERTILIZANTES1</th>
            <th>MANO_DE_OBRA1</th>
            <th>FLETES1</th>
            <th>RENTA1</th>
            <th>MAQUILA1</th>
            <th>EMPAQUE1</th>
            <th>TOTAL_DIRECTOS1</th>
            <th>TOTAL_INDIRECTOS1</th>
            <th>TOTAL_COSTO1</th>
            <th>COSTO_X_HA1</th>
            <th>COSTO_DE_EMPAQUE1</th>
            <th>NO_CAJAS1</th>
            <th>MANO_DE_OBRA2</th>
            <th>FLETES2</th>
            <th>MAQUILA2 </th>
            <th>EMPAQUE2</th>
            <th>TOTAL_COSTO_EMPAQUE1</th>
            <th>CAJAS_MERMADAS1</th>
            <th>NO_CAJAS2</th>
            <th>MANO_DE_OBRA3</th>
            <th>FLETES3</th>
            <th>MAQUILA3</th>
            <th>EMPAQUE3</th>
            <th>TOTAL_MERMAS1</th>
            <th>COSTO_TOTAL1 </th>
            <th>VENTAS_EXPOR1</th>
            <th>VENTAS_EMPAQUE1</th>
            <th>VENTAS_TAYLOR1</th>
            <th>VENTAS_FRESH_EXPRESS1</th>
            <th>VENTAS_GRANEL1</th>
            <th>VENTAS_RANCHO_VIEJO1</th>
            <th>VENTAS_ROYAL_ROSE1</th>
            <th>VENTAS_AVALON1</th>
            <th>COM_MONTERREY1</th>
            <th>COM_GUADALAJARA1</th>
            <th>VENTAS_ESA_FRESH1</th>
            <th>OTROS_CLIENTES1</th>
            <th>VENTAS_TOTALES1</th>
            <th>UTILIDAD_O_PERDIDA1</th>
        </tr>
    </thead>
    <tbody>
    </tbody>

</table>
<script type="text/javascript">
    $(document).ready(function() {

        $('#tablas').DataTable({
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
            keys: true,
            searchPanes: {
                cascadePanes: true,
                initCollapsed: true,
                columns: [0, 1, 3, 6],
                dtOpts: {
                    select: {
                        style: 'multi'
                    }
                }
            },
            dom: 'Plfrtip',
            ajax: {
                url: "{{route('datosTablas')}}",
                dataSrc: 'data'
            },
            columns: [{
                    data: 'MES1',
                    name: 'MES'
                },
                {
                    data: 'SEMANA1',
                    name: 'SEMANA'
                },
                {
                    data: 'TABLA1',
                    name: 'TABLA'
                },
                {
                    data: 'PRODUCTO1',
                    name: 'PRODUCTO'
                },
                {
                    data: 'CODIGO1',
                    name: 'CODIGO'
                },
                {
                    data: 'HECTAREAS1',
                    name: 'HECTAREAS'
                },
                {
                    data: 'RANCHO1',
                    name: 'RANCHO'
                },
                {
                    data: 'OBSERVACIONES1',
                    name: 'OBSERVACIONES'
                },
                {
                    data: 'REND_KG_X_HA1',
                    name: 'REND_KG_X_HA'
                },
                {
                    data: 'KGS_TOTALES1',
                    name: 'KGS_TOTALES'
                },
                {
                    data: 'PLANTULA1',
                    name: 'PLANTULA1'
                },
                {
                    data: 'AGROQUIMICOS1',
                    name: 'AGROQUIMICOS1'
                },
                {
                    data: 'FERTILIZANTES1',
                    name: 'FERTILIZANTES1'
                },
                {
                    data: 'MANO_DE_OBRA1',
                    name: 'MANO_DE_OBRA1'
                },
                {
                    data: 'FLETES1',
                    name: 'FLETES1'
                },
                {
                    data: 'RENTA1',
                    name: 'RENTA1'
                },
                {
                    data: 'MAQUILA1',
                    name: 'MAQUILA1'
                },
                {
                    data: 'EMPAQUE1',
                    name: 'EMPAQUE1'
                },
                {
                    data: 'TOTAL_DIRECTOS1',
                    name: 'TOTAL_DIRECTOS1'
                },
                {
                    data: 'TOTAL_INDIRECTOS1',
                    name: 'TOTAL_INDIRECTOS1'
                },
                {
                    data: 'TOTAL_COSTO1',
                    name: 'TOTAL_COSTO1'
                },
                {
                    data: 'COSTO_X_HA1',
                    name: 'COSTO_X_HA1'
                },
                {
                    data: 'COSTO_DE_EMPAQUE1',
                    name: 'COSTO_DE_EMPAQUE1'
                },
                {
                    data: 'NO_CAJAS1',
                    name: 'NO_CAJAS1'
                },
                {
                    data: 'MANO_DE_OBRA2',
                    name: 'MANO_DE_OBRA2'
                },
                {
                    data: 'FLETES2',
                    name: 'FLETES2'
                },
                {
                    data: 'MAQUILA2',
                    name: 'MAQUILA2'
                },
                {
                    data: 'EMPAQUE2',
                    name: 'EMPAQUE2'
                },
                {
                    data: 'TOTAL_COSTO_EMPAQUE1',
                    name: 'TOTAL_COSTO_EMPAQUE1'
                },
                {
                    data: 'CAJAS_MERMADAS1',
                    name: 'CAJAS_MERMADAS1'
                },
                {
                    data: 'NO_CAJAS2',
                    name: 'NO_CAJAS2'
                },
                {
                    data: 'MANO_DE_OBRA3',
                    name: 'MANO_DE_OBRA3'
                },
                {
                    data: 'FLETES3',
                    name: 'FLETES3'
                },
                {
                    data: 'MAQUILA3',
                    name: 'MAQUILA3'
                },
                {
                    data: 'EMPAQUE3',
                    name: 'EMPAQUE3'
                },
                {
                    data: 'TOTAL_MERMAS1',
                    name: 'TOTAL_MERMAS1'
                },
                {
                    data: 'COSTO_TOTAL1',
                    name: 'COSTO_TOTAL1'
                },
                {
                    data: 'VENTAS_EXPOR1',
                    name: 'VENTAS_EXPOR1'
                },
                {
                    data: 'VENTAS_EMPAQUE1',
                    name: 'VENTAS_EMPAQUE1'
                },
                {
                    data: 'VENTAS_TAYLOR1',
                    name: 'VENTAS_TAYLOR1'
                },
                {
                    data: 'VENTAS_FRESH_EXPRESS1',
                    name: 'VENTAS_FRESH_EXPRESS1'
                },
                {
                    data: 'VENTAS_GRANEL1',
                    name: 'VENTAS_GRANEL1'
                },
                {
                    data: 'VENTAS_RANCHO_VIEJO1',
                    name: 'VENTAS_RANCHO_VIEJO1'
                },
                {
                    data: 'VENTAS_ROYAL_ROSE1',
                    name: 'VENTAS_ROYAL_ROSE1'
                },
                {
                    data: 'VENTAS_AVALON1',
                    name: 'VENTAS_AVALON1'
                },
                {
                    data: 'COM_MONTERREY1',
                    name: 'COM_MONTERREY1'
                },
                {
                    data: 'COM_GUADALAJARA1',
                    name: 'COM_GUADALAJARA1'
                },
                {
                    data: 'VENTAS_ESA_FRESH1',
                    name: 'VENTAS_ESA_FRESH1'
                },
                {
                    data: 'OTROS_CLIENTES1',
                    name: 'OTROS_CLIENTES1'
                },
                {
                    data: 'VENTAS_TOTALES1',
                    name: 'VENTAS_TOTALES1'
                },
                {
                    data: 'UTILIDAD_O_PERDIDA1',
                    name: 'UTILIDAD_O_PERDIDA1'
                }
            ]
        });
    });
    </script>