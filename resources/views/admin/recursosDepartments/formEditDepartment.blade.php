<form method="POST" id="formEditDepartment" enctype="multipart/form-data">
    @csrf
    <div class="form-group mt-4">
        <input id="id" name="id" value='{{$dept->id}}' type="text" hidden>
        <label for="exampleInputEmail1">Nombre</label>
        <input id="name" name="name" value='{{$dept->name}}' type="text" class="form-control" placeholder="Nombre">
    </div>
    <label for="exampleInputEmail1">Status</label>
    <div class="form-group">
        <label><input id="status" name="status" value='0' type="radio" {{($dept->status==0)?'checked':''}} > Deshabilitado</label>
        <label><input id="status" name="status" value='1' type="radio" {{($dept->status==1)?'checked':''}} > Habilitado</label>
    </div>
    <div class="flex items-center justify-end mt-4">
        <button id="btnEditDepartment"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Actualizar</button>
    </div>
</form>
<script type="text/javascript">
$(document).ready(
    function() {
        //Edita usuario
        $("#btnEditDepartment").confirm({
            title: 'Editar departamento',
            content: "Se actualizarán los datos del departamento",
            buttons: {
                Actualizar: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    //Ajax para agregar nuevo departamento
                    $.ajax({
                        url: "/updateDepartment",
                        type: 'POST',
                        data: $("#formEditDepartment").serialize(),
                        success: function(data) {
                            refreshAcordeon();
                        }
                    });
                    //fin de ajax

                },
                Cerrar: function() {}
            }
        });
        //Fin edit user
    }
);
</script>