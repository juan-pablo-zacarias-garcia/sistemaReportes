<x-app-layout>
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <div class="col-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto col-12 ">
                <div class="p-4 sm:p-12 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="col-12 ">
                        <table id="tablaArchivos" class="table table-bordered table-condensed table-striped col-md-8">
                            <thead>
                                <tr>
                                    <th>Archivos disponibles de {{$department}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listaArchivos as $archivo)
                                <tr>
                                    <td><button onclick="vistaRapida('{{$archivo}}')"><span class="text-primary">{{$archivo}}</span></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
<script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
<script type="text/javascript">
function vistaRapida(path) {
    $.confirm({
        title: '',
        content: function() {
            return "<iframe width='100%' height='1000' src='/getFile/" + path + "' ></iframe>";
        },
        useBootstrap: false,
        boxWidth: '100%',
        theme: 'supervan',
        buttons: {
            Cerrar: function() {}
        }
    });
}

$(document).ready(function() {
    //Mostrar PDF

});
</script>