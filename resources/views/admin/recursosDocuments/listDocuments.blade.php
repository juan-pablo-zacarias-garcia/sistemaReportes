<link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
<div id="accordion">
    @foreach( $directories as $directory)
    <h3>{{$directory}}</h3>
    @php
    //Devuelve solo los archivos de la carpeta del departamento
    $Archivos=Storage::disk('documentos',)->allFiles($directory);
    //Filtramos solo los pdf
    $Archivos = array_filter($Archivos, function($v, $k) {
    return substr($v, -4)==".pdf";
    }, ARRAY_FILTER_USE_BOTH);
    @endphp
    <div><span>Archivos:</span>
        <ul>
            @foreach($Archivos as $Archivo)
            <li><button onclick="vistaRapida('{{$Archivo}}')">{{$Archivo}}</button></li>
            @endforeach
        </ul>
    </div>
    @endforeach
</div>
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
    $("#accordion").accordion({
        collapsible: true
    });

});

</script>