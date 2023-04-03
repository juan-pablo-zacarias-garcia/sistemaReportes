@if (Auth::user()->type==env('USER_ADMIN'))
<form method="POST"  id="newUserForm" class="mt-6 space-y-6">
    @csrf
    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Nombre completo')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
            autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Correo electrónico')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
            autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Department -->
    <div class="mt-4">
        <x-input-label for="department" :value="__('Departamento')" />
        <select id="department" class="block mt-1 w-full" name="department">
            @foreach ($departments as $department)
            <option value="{{$department->id}}" >{{$department->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Contraseña')" />

        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
            autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        <label class="text-secondary">La contraseña debe ser de mínimo 8 caracteres</label>
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirma contraseña')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
            required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" id="btnNewUserForm"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Agregar</button>
    </div>
</form>

<script type="text/javascript">
$(document).ready(
    function() {
        //Agrega usuario
        $("#btnNewUserForm").confirm({
            title: 'Nuevo usuario',
            content: "Se agregará un nuevo usuario",
            buttons: {
                Agregar: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    //Ajax para agregar nuevo departamento
                    $.ajax({
                        url: "/registerUser",
                        type: 'POST',
                        data: $("#newUserForm").serialize(),
                        success: function(data) {
                            $.confirm({
                                title:'Usuario registrado',
                                content:'El usuario ha sido registrado',
                                buttons: {
                                    Cerrar: function(){},
                                }
                            });
                            $("#name").val("");
                            $("#email").val("");
                            $("#password").val("");
                            $("#password_confirmation").val("");
                            //cargamos la tabla de los usuarios
                            $("#tablaUsuarios").load('/tablaUsuarios');
                        },
                        error: function(data){
                            $.confirm({
                                title:'Error al registrar usuario',
                                content:'Revise los datos y vuelva a intentar',
                                buttons: {
                                    Cerrar: function(){},
                                }
                            });
                        }
                    });
                    //fin de ajax

                },
                Cerrar: function() {}
            }
        });
        //Fin edit user
    }
);
</script>
@endif