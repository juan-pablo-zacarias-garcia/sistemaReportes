<x-app-layout>
    <!-- Manejador de mensajes -->
    @isset($msg)
    @php
    switch($msg){
    //Si el usuario intenta ingresar a un archivo que no es de su departamento
    case '1':
    echo "<h3 class='text-danger'>Acceso denegado, ".auth()->user()->name." se realizará un cargo de $100 a su nómina.
        Gracias</h3></br><img src='https://i.pinimg.com/236x/d4/3e/2a/d43e2a6518eafa497c0fdad475fbc2eb.jpg' />";
    break;
    };
    @endphp
    @endisset
    <div class="my-5">
        <div class=" text-center bg-body-tertiary">
            <div class="container ">
                <h1 class="text-body-emphasis">
                    <div class='m-0 row justify-content-center'><img class='col-auto text-center'
                            src="{{asset('assets/img/agricola_nieto.png')}}"></div>
                </h1>
                <p class="col-lg-8 mx-auto lead">
                    Somos una empresa pionera y líder en el mercado de los vegetales. Nuestra <code>fortaleza</code> se
                    fundamenta con casi <code>100 años</code> de experiencia, ofrecemos una amplia gama de productos y
                    servicios de alta <code>calidad</code>, cuidando nuestro producto en cada <code>eslabón</code> de la
                    cadena de suministro, para entregar con el sabor, color, tamaño y textura que el cliente necesita.
                </p>
            </div>
        </div>
    </div>

</x-app-layout>