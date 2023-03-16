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
                    <form action="{{ route('uploadFile') }}" method="POST" id="file-upload"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Departamento
                                <select id="department" class="block mt-1 w-full" name="department">
                                    @php
                                    $deps=DB::select("select * from departments");
                                    @endphp
                                    @foreach ($deps as $dep)
                                    <option value="{{$dep->name}}">{{$dep->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="file" accept="application/pdf" name="file" id="inputFile" class="form-control">
                            <span class="text-danger" id="file-input-error"></span>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Subir archivo</button>
                        </div>

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

        //Se configura ajax para que mande el token csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //cuando se envíe el formulario
        $('#file-upload').submit(function(e) {
            e.preventDefault();
            //se crea un nuevo objeto FormData de JS y se le agrega el formulario (this)
            let formData = new FormData(this);
            //se agrega al formData el departamento al que se cargará el archivo
            formData.append('department', $('#department').val());

            $('#file-input-error').text('');
            //Se realiza la petición ajax para cargar el archivo
            $.ajax({
                type: 'POST',
                url: "{{ route('uploadFile') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        if(response=="#"){
                            window.alert("Error a cargar archivo. El archivo ya existe");
                        }
                    }
                    refreshAcordeon();
                },
                error: function(response) {
                    console.log(response.responseJSON.message);
                    $('#file-input-error').text("Error al cargar el archivo");
                }
            });

        });


    });

    //Elimina un archivo
    function deleteFile(path) {
        $.confirm({
            title: '',
            content: function() {
                return "¿Está seguro de eliminar el documento: " + path + "?";
            },
            buttons: {
                Eliminar: function() {
                    $.ajax({
                        url: "deleteFile/" + path,
                        type: "GET"
                    }).done(function(data) {
                        refreshAcordeon();
                    });
                },
                Cancelar: function() {}
            }
        });
    }

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