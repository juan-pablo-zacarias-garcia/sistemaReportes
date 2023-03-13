<form method="POST" id="formNewDepartment" enctype="multipart/form-data">
    @csrf
    <div class="form-group mt-4">
        <label for="exampleInputEmail1">Nombre</label>
        <input id="name" name="name" value='' type="text" class="form-control" placeholder="Nombre">
    </div>
    <div class="flex items-center justify-end mt-4">
        <button id="newDepartmentForm"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Actualizar</button>
    </div>
</form>
<script type="text/javascript">
$(document).ready(
    function() {
        //Edita usuario
        $("#newDepartmentForm").confirm({
            title: 'Nuevo departamento',
            content: "Se agregará un nuevo departamento",
            buttons: {
                confirm: function() {

                    //Ajax para agregar nuevo departamento
                    $.ajax({
                        url: "/registerDepartment",
                        type: 'POST',
                        data: $("#formNewDepartment").serialize(),
                        success: function(data) {}
                    });
                    //fin de ajax

                },
                cancel: function() {}
            }
        });
        //Fin edit user
    }
);
</script>