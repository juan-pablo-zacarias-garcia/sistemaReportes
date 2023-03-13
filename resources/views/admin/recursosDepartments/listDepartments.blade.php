
@foreach( $departments as $department)
<h3>{{$department->name}}</h3>
@php
$users = DB::select("select * from users where department=".$department->id);
@endphp
<div><span>Usuarios</span>
    <ul>
        @foreach($users as $user)
        <li>{{$user->name}}</li>
        @endforeach
    </ul>
</div>
@endforeach