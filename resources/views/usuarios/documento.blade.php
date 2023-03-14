<x-app-layout>
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <table id="tablaArchivos" class="table table-bordered table-condensed table-striped col-md-8">
        <thead>
            <tr>
                <th>Archivos disponibles de {{$department}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaArchivos as $archivo)
            <tr>
                <td><button onclick="vistaRapida('{{$archivo}}')" >{{$archivo}}</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
<script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
<script type="text/javascript">

function vistaRapida(path){
    $.confirm({
        title: '',
        content: function() {
            return "<iframe width='100%' height='1000' src='/getFile/"+path+"' ></iframe>";
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