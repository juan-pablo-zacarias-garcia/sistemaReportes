<x-app-layout>
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <button id="pdf" class="btn btn-secondary">Vista rápida</button>
    {{$urlPDF}}

</x-app-layout>
<script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    //Mostrar PDF
    $("#pdf").confirm({
        title: '',
        content: function() {
             return "<iframe width='100%' height='1000' src='{{asset('assets/ejemplo.pdf')}}' ></iframe>";
        },
        useBootstrap: false,
        boxWidth:'100%',
        theme: 'supervan',
        buttons: {
            Cerrar: function() {}
        }
    });
});
</script>