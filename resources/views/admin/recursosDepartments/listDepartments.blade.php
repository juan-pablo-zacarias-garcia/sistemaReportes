<link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
<div id="accordion">
    @foreach( $departments as $department)
    <h3>{{$department->name}} (
        @php
        $total = DB::select("select count(id)total from users where department=".$department->id);
        echo $total[0]->total;
        @endphp
        )</h3>
    @php
    $users = DB::select("select * from users where department=".$department->id);
    @endphp
    <div>
        <button onclick="editDepto({{$department->id}})" class="btn btn-outline-primary"><img
                src="{{asset('assets/icon/edit.png')}}" /></button>
        <hr>
        <span>Status: {{($department->status==0?'Deshabilitado':'Habilitado')}}</span>
        <hr>
        <div class="col-auto text-center"><h4>Usuarios:</h4></div>
        <hr>
        <ul>
            @foreach($users as $user)
            <li>{{$user->name}}</li>
            <hr>
            @endforeach
        </ul>
    </div>
    @endforeach
</div>
<script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#accordion").accordion({
        collapsible: true
    });
    $('#ui-id-1').trigger('click');
});

function editDepto(id) {
    //Editar departamento
    $.confirm({
        title: 'Editar departamento',
        content: function() {
            //carga el formulario para editar el usaurio
            url = "/FormEditDepartment/" + id;
            return 'url:' + url;
        },
        buttons: {
            Cerrar: function() {}
        }
    });
}
</script>