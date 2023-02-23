@if (Auth::user()->isAdmin==1)
<table id="usuarios" class="table table-bordered table-condensed table-striped col-md-12">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Fecha de registro</th>
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script type="text/javascript">
var table;
$(document).ready(function() {
    //Guardamos la tabla para trabajar con ella
    table = $('#usuarios').DataTable({
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
        scrollY: 400,
        select: true,
        ajax: {
            url: "{{route('datosUsuarios')}}",
            dataSrc: 'data'
        },
        columns: [{
                data: 'id',
                name: 'ID'
            },
            {
                data: 'name',
                name: 'Nombre'
            },
            {
                data: 'email',
                name: 'Correo'
            },
            {
                data: 'created_at',
                name: 'Fecha de registro'
            },
            {
                data: 'isAdmin',
                name: 'Rol'
            },
        ]
    });
});
//Evento al seleccionar fila de la tabla
var rowSelected = null;
$('#usuarios tbody').on('click', 'tr', function() {


    if (rowSelected != table.row(this).data()) {
        rowSelected = table.row(this).data();
        document.getElementById("editUser").hidden = false;
        document.getElementById("delUser").hidden = false;
        //Cambiamos el valor de los inputs ocultos en la vista Usuarios
        document.getElementById('idUser').value = rowSelected.id;
        document.getElementById('emailUser').value = rowSelected.email;
    } else {
        document.getElementById("editUser").hidden = true;
        document.getElementById("delUser").hidden = true;
        rowSelected = null;
        //Cambiamos el valor de los inputs ocultos en la vista Usuarios
        document.getElementById('idUser').value = "";
        document.getElementById('emailUser').value = "";
    }
});
</script>
@endif