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
        <button id="btnEditDept" class="btn btn-outline-primary"><img
                src="{{asset('assets/icon/edit.png')}}" /></button>
        <hr>
        <span>Usuarios:</span>
        <ul>
            @foreach($users as $user)
            <li>{{$user->name}}</li>
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
});
</script>