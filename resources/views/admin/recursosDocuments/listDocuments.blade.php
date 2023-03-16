<link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
<h4>Carpetas de departamentos</h4>
<div id="accordion">
    @foreach( $directories as $directory)

    @php
    //Devuelve solo los archivos de la carpeta del departamento
    $Archivos=Storage::disk('documentos',)->allFiles($directory);
    //Filtramos solo los pdf
    $Archivos = array_filter($Archivos, function($v, $k) {
    return substr($v, -4)==".pdf";
    }, ARRAY_FILTER_USE_BOTH);
    @endphp
    <h3>{{$directory}} ({{count($Archivos)}})</h3>
    <div>
        <div class="col-auto text-center">
            <h4>Archivos:</h4>
        </div>
        <ul>
            <hr>
            @foreach($Archivos as $Archivo)
            <li>
                <button onclick="deleteFile('{{$Archivo}}')"><img id="imgDelete"
                        src="{{asset('assets/icon/delete16.png')}}" title="Eliminar archivo" /></button>
                <button onclick="vistaRapida('{{$Archivo}}')"><span class="text-primary">{{$Archivo}}</span></button>
            </li>
            <hr>
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