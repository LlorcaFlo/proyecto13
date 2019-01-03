<?php

/**
 * Created by PhpStorm.
 * User: josellorca
 * Date: 2018-12-23
 * Time: 22:04
 */

namespace Mini\Controller;


use Mini\Core\Controller;
use Mini\Core\View;
use Mini\Core\Session;
use Mini\Model\Usuario;
use Mini\Model\Validate;
use Mini\Model\Conexion;

class UsuariosController extends Controller

{

    public function __construct()
    {
        parent::__construct();
        $this->titulo = 'Preguntas';
    }

    public function index()
    {
        // load views
        $this->view->addData(['titulo' => 'Usuarios']);
        echo $this->view->render('usuarios/index', ['titulo' => 'Usuario']);
    }

    public function muestraUsuarios()
    {
        $usuario = new Usuario();
        $usuarios = $usuario->allEmpleados();
        echo $this->view->render('/usuarios/muestraUsuarios', ['usuario' => $usuarios, 'titulo' => $this->titulo]);
    }


    public function cierrasesion()
    {
        $user = new Session();
        $user->destroy();
        $this->view->addData(['titulo' => 'Inicio']);
        echo $this->view->render('home/index', ['titulo' => 'Inicio']);
    }

    //<!--- CONTROL DE LOS USUARIOS---// EDITAR, BORRAR...

    public function update()
    {
        $this->view->addData(['titulo' => 'Editar Usuario']);

        $datos = [];
        $val = new Validate();
        $user = new Usuario();

        $usuario = $user->getId(Session::get('Id'));
        //var_dump($usuario);
        foreach ($usuario as $user) {
            $datos['nombre'] = $user->nombre;
            $datos['apellido'] = $user->apellido;
            $datos['email'] = $user->email;
            $datos['nickname'] = $user->nickname;
        }

        if (isset($_POST['Edita_user'])) {

            //NOMBRE----
            if (!$val->vacio($_POST['nombre'])) {
                $val->errors['nombre'] = 'No hemos recibido el nombre.';
            } elseif (!$val->va_name($_POST['nombre'])) {
                $val->errors['nombre'] = 'El nombre introducido no es válido.';
            } else {
                $datos['nombre'] = $_POST['nombre'];
            }

            //APELLIDO----
            if (!$val->vacio($_POST['apellido'])) {
                $val->errors['apellido'] = 'No hemos recibido el apellido.';
            } elseif (!$val->va_lastname($_POST['apellido'])) {
                $val->errors['apellido'] = 'El apellido introducido no es válido.';
            } else {
                $datos['apellido'] = $_POST['apellido'];
            }

            //EMAIL---- HARÁ LLAMADA A LA BASE DE DATOS, Y COMPROBARÁ QUE NO ESTÁ EN USO, APARTE DE
            //SUS OTRAS VALIDACIONES..
            $user = new Usuario();

            if (!$val->vacio($_POST['email'])) {
                $val->errors['email'] = 'No hemos recibido el email.';
            } elseif (!$val->va_email($_POST['email'])) {
                $val->errors['email'] = 'No hemos recibido un email válido.';
                $datos['email'] = $_POST['email'];
            } elseif (!$val->uniqueEmail($_POST['email'])) {
                if (!$user->emailId(Session::get('Id'), $_POST['email']))
                    $val->errors['email'] = 'El email ya está en uso, introduzca otro.';
                $datos['email'] = $_POST['email'];
            } else {
                $datos['email'] = $_POST['email'];
            }

            //NICKNAME---- HARÁ LLAMADA A LA BASE DE DATOS, Y COMPROBARÁ QUE NO ESTÁ EN USO, APARTE DE
            //SUS OTRAS VALIDACIONES...
            if (!$val->vacio($_POST['nickname'])) {
                $val->errors['nickname'] = 'No hemos recibido el Nick.';
            } elseif (!$val->va_nick($_POST['nickname'])) {
                $val->errors['nickname'] = 'El nick debe tener menos de 6 caracteres.';
                $datos['nickname'] = $_POST['nickname'];
            } elseif (!$val->uniqueNick($_POST['nickname'])) {
                if (!$user->nickId(Session::get('Id'), $_POST['nickname']))
                    $val->errors['nickname'] = 'El nick ya está en uso, introduzca otro.';
                $datos['nickname'] = $_POST['nickname'];

            } else {
                $datos['nickname'] = $_POST['nickname'];
            }

            if ($val->errors) {
                echo $this->view->render('usuarios/edita_form',
                    ['errors' => $val->errors, 'datos' => $datos]);
            } else {
                $datos_usuario = [
                    'nombre' => $datos['nombre'],
                    'apellido' => $datos['apellido'],
                    'email' => $datos['email'],
                    'nickname' => $datos['nickname']
                ];
                $user->update($datos_usuario, ['id' => Session::get('Id')]);
                $variable = 'Usuario editado';
                echo $this->view->render('usuarios/edita_form',
                    ['errors' => $val->errors, 'datos' => $datos, 'variable' => $variable]);
            }

        } else {
            echo $this->view->render('usuarios/edita_form',
                ['errors' => $val->errors, 'datos' => $datos]);
        }


    }

}
