<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class mailController extends Controller
{
    function sendMailRegister($email, $password)
    {
        Mail::to($email)->send(new UsuarioRegistrado($email,$password));
    }
    function sendMailResetPassword($email, $password)
    {
        Mail::to($email)->send(new PasswordReset($email,$password));
    }
}

class UsuarioRegistrado extends Mailable
{
    use Queueable, SerializesModels;
    var $user;
    var $password;
    function __construct($user, $password){
        $this->user = $user;
        $this->password = $password;
    }
    public function build()
    {
        $title = "Registro  de usuario";
        $subtitle = "Ha sido registrado en la aplicación web ".env('APP_NAME');
        $content = "Ingrese a la siguiente liga: ".env('URL_SITIO')."
         y cambie su contraseña entrando a 'Mi cuenta' en el menú lateral y en la sección 'Actualizar contraseña'";
        return $this->view('mail.plantilla1', ['title' => $title, 'subtitle' => $subtitle, 'content' => $content, 'user'=>$this->user, 'pass'=>$this->password]);
    }
}

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    var $user;
    var $password;
    function __construct($user, $password){
        $this->user = $user;
        $this->password = $password;
    }
    public function build()
    {
        $title = "Nueva contraseña";
        $subtitle = "Contraseña restablecida";
        $content = "Ingrese a la siguiente liga: ".env('URL_SITIO')."
         y cambie su contraseña entrando a 'Mi cuenta' en el menú lateral y en la sección 'Actualizar contraseña'";
        return $this->view('mail.plantilla1', ['title' => $title, 'subtitle' => $subtitle, 'content' => $content, 'user'=>$this->user, 'pass'=>$this->password]);
    }
}