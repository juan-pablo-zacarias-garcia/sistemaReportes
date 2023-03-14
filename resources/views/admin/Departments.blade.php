<x-app-layout class="col-md-9">
    @if (Auth::user()->type==env('USER_ADMIN'))
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12 space-y-12">
            <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3>Departamentos</h3>
                <hr>
                <button id="addDepartment" class="btn btn-success">
                    Agregar departamento
                </button>
                <button id="editDepartment" hidden="true" class="btn btn-secondary">
                    Editar departamento
                </button>
                <button id="delDepartment" hidden="true" class="btn btn-danger">
                    Eliminar departamento
                </button>
                <input id="idDepartment" type="hidden" value="">
                <hr>
                <div id="accordion">
                    
                </div>
            </div>

        </div>
    </div>
    </div>
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#accordion").accordion({
            collapsible: true
        });
        refreshAcordeon();
        $("#addDepartment").confirm({
            title: 'Nuevo departamento',
            content: 'url:{{route("FormNewDepartment")}}',
            columnClass: 'medium',
            buttons: {
                Cerrar: function() {}
            }
        });
    });

    //Recarga los datos de la lista de departamentos con sus usuarios
    function refreshAcordeon() {
        $.ajax({
            url: "listDepartments",
            type: "GET"
        }).done(function(data) {
            $("#accordion").empty();
            $("#accordion").append(data);
            $("#accordion").accordion("refresh");
        });
    }
    </script>
    @else
    <h1>Acceso denegado, su intento ha sido registrado</h1>
    @endif
</x-app-layout>