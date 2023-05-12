<x-app-layout>
    <link rel="stylesheet" href="{{asset('assets/css/jquery-confirm.min.css')}}" />
    <script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
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
            <div class="container">
                <h1 class="text-body-emphasis">
                    <div id="imgagn" style class='m-0 row justify-content-center'><img class='col-auto text-center'
                            src="{{asset('assets/img/agricola_nieto.png')}}"></div>
                </h1>
                <div class='m-0 row justify-content-center'><textarea readonly class="hidden text-center" id="textExample"
                        rows="20" cols="80"
                        style="border: none; font-size:1.2em;">Somos una empresa pionera y líder en el mercado de los vegetales. Nuestra fortaleza se fundamenta con casi 100 años de experiencia, ofrecemos una amplia gama de productos y servicios de alta calidad, cuidando nuestro producto en cada eslabón de la cadena de suministro, para entregar con el sabor, color, tamaño y textura que el cliente necesita.</textarea>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        animateImg();
        setTimeout(function() {
            $("#textExample").removeClass("hidden");
            animateText(textExample);
        }, 1000);
        // agranda imagen
        setTimeout(function() {
            animate({
                duration: 200,
                timing: intervaloimg1,
                draw: function(progress) {
                    $('#imgagn').css('-webkit-transform', 'scale(' + progress + ')');
                }
            });
        }, 14100);
        // reduce imagen
        setTimeout(function() {
            animate({
                duration: 5000,
                timing: intervaloimg2,
                draw: function(progress) {
                    $('#imgagn').css('-webkit-transform', 'scale(' + progress + ')');
                }
            });
        }, 14300);

    });
    </script>
    <script>
    // Funcipon para animar el texto
    function animateText(textArea) {
        let text = textArea.value;
        let to = text.length,
            from = 0;

        animate({
            duration: 13000,
            timing: intervalo,
            draw: function(progress) {
                let result = (to - from) * progress + from;
                textArea.value = text.slice(0, Math.ceil(result))
            }
        });
    }
    // Función para animar la imagen
    function animateImg() {
        animate({
            duration: 3000,
            timing: intervalo,
            draw: function(progress) {
                $('#imgagn').css('opacity', progress);
            }
        });
    }

    //retorna un valor entre 0 y 1
    function intervalo(timeFraction) {
        for (var a = 1; 100; a++) {
            return a * timeFraction;
        }
    }
    // retorna un valor entre 1 y 1.3
    function intervaloimg1(timeFraction) {
        for (var a = 1; 100; a++) {
            return (1 + (timeFraction * 0.5));
        }
    }
    // retorna un valor entre 1.3 y 1
    function intervaloimg2(timeFraction) {
        for (var a = 100; 1; a--) {
            return (1.5 - (timeFraction * 0.5));
        }
    }

    // función para animar
    function animate({
        timing,
        draw,
        duration
    }) {
        let start = performance.now();
        requestAnimationFrame(function animate(time) {
            // timeFraction va de 0 a 1
            let timeFraction = (time - start) / duration;
            if (timeFraction > 1) timeFraction = 1;
            // calcular el estado actual de la animación
            let progress = timing(timeFraction);
            draw(progress); // dibujar
            if (timeFraction < 1) {
                requestAnimationFrame(animate);
            }

        });
    }
    </script>
</x-app-layout>