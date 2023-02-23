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

        //obtiene el valor del input oculto
        $('#delUser').on('click',function(){
            idUser = document.getElementById('idUser').value;
            emailUser = document.getElementById('emailUser').value;
        });


        //Elimina usuario
        
        $("#delUser").confirm({
            title: 'Eliminar usuario',
            content: "El usuario" + idUser + " será eliminado del sistema",
            buttons: {
                confirm: function() {

                },
                cancel: function() {
                    $.alert('Canceled!');
                }
            }
        });

    });

    function deleteUser(id) {
        $.ajax({
            url: "/deleteUser/" + id,
            type: 'get',
            success: function(response) {
                //cargamos la tabla de los usuarios
                $("#tablaUsuarios").load('/tablaUsuarios');
            }
        })
    }

    function editUser() {
        window.alert("hola");
    }
    </script>
    @else
    <h1>Acceso denegado, su intento ha sido registrado</h1>
    @endif
</x-app-layout>