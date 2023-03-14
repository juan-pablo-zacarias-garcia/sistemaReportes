<x-app-layout>
    <!-- Manejador de mensajes -->
    @isset($msg)
    @php
    switch($msg){
    //Si el usuario intenta ingresar a un archivo que no es de su departamento
    case '1':
    echo "<h3 class='text-danger'>Acceso denegado, ".auth()->user()->name." se realizará un cargo de $100 a su nómina. Gracias</h3></br><img
        src='https://i.pinimg.com/236x/d4/3e/2a/d43e2a6518eafa497c0fdad475fbc2eb.jpg' />";
    break;
    };
    @endphp

    @endisset
</x-app-layout>