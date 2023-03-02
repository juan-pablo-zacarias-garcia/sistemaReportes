 <form method="POST" id="formEditUser" enctype="multipart/form-data">
     @csrf
     <div class="form-group mt-4">
         <input id="id" name="id" value='{{$user->value("id")}}' hidden>
         <label for="exampleInputEmail1">Nombre</label>
         <input id="name" name="name" value='{{$user->value("name")}}' type="text" class="form-control"
             placeholder="Nombre">
     </div>
     <div class="form-group mt-4">
         <label for="exampleInputEmail1">Correo</label>
         <input id="email" name="email" value='{{$user->value("email")}}' type="email" class="form-control"
             aria-describedby="emailHelp" placeholder="Enter email">
         <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
     </div>
     <div class="form-group mt-4">
         <label for="exampleInputPassword1">Password</label>
         <input id="password" name="password" type="password" class="form-control" id="exampleInputPassword1"
             placeholder="Password">
     </div>
     <div class="form-group">
         <label>Rol</label>
         <br />
         <label><input name="type" value='0' type="radio" {{$user->value("type")==0?'checked':''}}>Usuario</label>
         <br />
         <label><input name="type" value='1' type="radio"
                 {{$user->value("type")==1?'checked':''}}>Administrador</label>
     </div>
     <div class="flex items-center justify-end mt-4">
         <button id="editUserForm"
             class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Actualizar</button>
     </div>
 </form>
 <script type="text/javascript">
$(document).ready(
    function() {
        //Edita usuario
        $("#editUserForm").confirm({
            title: 'Advertencia',
            content: "Los datos del usuario serán modificados",
            buttons: {
                confirm: function() {

                    //Ajax para eliminar el usuario
                    $.ajax({
                        url: "/updateUser",
                        type: 'POST',
                        data: $("#formEditUser").serialize(),
                        success: function(data) {
                            $.alert('Los datos del usuario: ' + data.email + " con id: " +
                                data.id + " han sido actualizado");
                            //cargamos la tabla de los usuarios
                            $("#tablaUsuarios").load('/tablaUsuarios');
                            //Reinicimos los botones 
                            document.getElementById("editUser").hidden = true;
                            document.getElementById("delUser").hidden = true;
                            rowSelected = null;
                            //Cambiamos el valor de los inputs ocultos en la vista Usuarios
                            document.getElementById('idUser').value = "";
                            document.getElementById('emailUser').value = "";
                        }
                    });
                    //fin de ajax

                },
                cancel: function() {}
            }
        });
        //Fin edit user
    }
);
 </script>