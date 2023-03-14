<x-app-layout>
    @if (Auth::user()->type==env('USER_ADMIN'))
    <link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/select.dataTables.min.css')}}" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12 space-y-12">
            <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3>Documentos</h3>
                <hr>
                <div>
                    <form method="POST" id="formNewDocument" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <button id="btnUpload"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Subir archivo</button>
                    </form>
                </div>
                <button id="delDocument" hidden="true" class="btn btn-danger">
                    Eliminar documento
                </button>
                <hr>
                <div id="divAccordion">

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
        refreshAcordeon();

        //Carga el archivo al servidor
        $("#btnUpload").confirm({
            title: 'Nuevo archivo',
            content: "Se agregará un nuevo archivo",
            buttons: {
                confirm: function() {
                    var formData = new FormData(document.getElementById("formNewDocument"));
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    //Ajax para agregar nuevo departamento
                    $.ajax({
                        url: "uploadFile",
                        type: "post",
                        success: function(data) {
                            window.alert(data);
                        }
                    });
                    //fin de ajax

                },
                Cerrar: function() {}
            }
        });

    });

    //Recarga los datos de la lista de departamentos con sus usuarios
    function refreshAcordeon() {
        $.ajax({
            url: "listDocuments",
            type: "GET"
        }).done(function(data) {
            $("#divAccordion").empty();
            $("#divAccordion").append(data);
        });
    }
    </script>
    @else
    <h1>Acceso denegado, su intento ha sido registrado</h1>
    @endif
</x-app-layout>