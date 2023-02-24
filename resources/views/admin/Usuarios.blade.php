<x-app-layout class="col-md-9">
    @if (Auth::user()->isAdmin==1)
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12 space-y-12">
            <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3>Usuarios</h3>
                <hr>
                <button id="addUser" class="btn btn-success">
                    Agregar usuario
                </button>
                <button id="editUser" hidden="true" class="btn btn-secondary">
                    Editar usuario
                </button>
                <button id="delUser" hidden="true" class="btn btn-danger">
                    Eliminar usuario
                </button>
                <input id="idUser" type="hidden" value="">
                <input id="emailUser" type="hidden" value="">

                <hr>
                <div id="tablaUsuarios">

                </div>

            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
    <script type="text/javascript">
    //cargamos la tabla de los usuarios
    $("#tablaUsuarios").load('/tablaUsuarios');
    //CUadno se cargue el documento
    $(document).ready(function() {
        //Agrega usuarios
        $("#addUser").confirm({
            title: 'Nuevo usuario',
            content: 'url:{{route("FormNewUser")}}',
            columnClass: 'medium',
            buttons: {
                cancel: function() {}
            }
        });

        //Editar usuario
        $("#editUser").confirm({
            title: 'Editar usuario',
            content: function() {
                //carga el formulario para editar el usaurio
                id = document.getElementById("idUser").value;
                url = "/FormEditUser/" + id;
                return 'url:' + url;
            },
            buttons: {
                Cerrar: function() {}
            }
        });


        //Elimina usuario

        $("#delUser").confirm({
            title: 'Advertencia',
            content: function() {
                return "El usuario " + document.getElementById("emailUser").value +
                    " será eliminado";
            },
            buttons: {
                confirm: function() {
                    id=document.getElementById("idUser").value;
                    email=document.getElementById('emailUser').value;
                    //Ajax para eliminar el usuario
                    $.ajax({
                        url: "/deleteUser/" + id,
                        type: 'get',
                        success: function(data) {
                            if (data.result != 'true') {
                                $.alert('El usuario ' + email +" ha sido eliminado");
                            }else{
                                $.alert("Ha ocurrido un error al eliminar el usuario "+email);
                            }
                        }
                    });
                    //fin de ajax
                    
                    //cargamos la tabla de los usuarios
                    $("#tablaUsuarios").load('/tablaUsuarios');
                    //Reinicimos los botones 
                    document.getElementById("editUser").hidden = true;
                    document.getElementById("delUser").hidden = true;
                    rowSelected = null;
                    //Cambiamos el valor de los inputs ocultos en la vista Usuarios
                    document.getElementById('idUser').value = "";
                    document.getElementById('emailUser').value = "";
                },
                cancel: function() {}
            }
        });


    });



    function deleteUser(id) {
        $.ajax({
            url: "/deleteUser/" + id,
            type: 'get',
            success: function(data) {
                if (data.result != 'true') {
                    alert('El usuario ya existe: ');
                }
            }
        });
    }
    </script>
    @else
    <h1>Acceso denegado, su intento ha sido registrado</h1>
    @endif
</x-app-layout>