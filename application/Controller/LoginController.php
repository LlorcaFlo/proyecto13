<?php
/**
 * Created by PhpStorm.
 * User: josellorca
 * Date: 2018-12-04
 * Time: 20:03
 */

namespace Mini\Controller;

use Mini\Core\View;
use Mini\Model\Validate;
use Mini\Model\Usuario;
use Mini\Core\Controller;
use Mini\Core\Session;
use Mini\Core\TemplatesFactory;
use mysql_xdevapi\BaseResult;
use mysql_xdevapi\Exception;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->titulo = 'Página Acesso';
    }

    public function index()
    {
        $this->view->addData(['titulo' => 'Página Acesso']);

        $datos = [];
        $val = new Validate();
        $user = new Usuario();

        //Si se pulsa el botón de acceso a login
        if (isset($_POST['acceso_login'])) {

            $_POST['login'] = $val->sanitize($_POST['login']);
            $_POST['password'] = $val->sanitize($_POST['password']);

            if (!isset($_POST['login']) OR empty($_POST['login'])) {
                $val->errors['login'] = 'No has introducido ningún usuario.<br>';
                $datos['login'] = $_POST['login'];

            } elseif (!isset($_POST['password']) OR empty($_POST['password'])) {
                $val->errors['password'] = 'No has introducido ninguna contraseña.<br>';
                $datos['login'] = $_POST['login'];

            } else {

                if ($_POST['select'] === 'Nick') {
                    $_POST['password'] = $user->md5Clave($_POST['password']);
                    try {
                        $user = $user->nickPass($_POST['login'], $_POST['password']);
                    } catch (PDOException $e) {
                        echo 'Error! ' . $e->getMessage() . ' // Linea-> ' . $e->getLine();
                    }
                    if (!$user) {
                        $val->errors['password'] = 'No existe usuario en la base de datos.<br>';
                        $datos = [
                            'nick' => $_POST['login'],
                        ];
                    } else {
                        $datos = [
                            'nick' => $_POST['login'],
                            'clave' => $_POST['password']
                        ];
                    }
                }
                if ($_POST['select'] === 'Email') {
                    $_POST['password'] = $user->md5Clave($_POST['password']);
                    try {
                        $user = $user->emailPass($_POST['login'], $_POST['password']);
                    } catch (PDOException $e) {
                        echo 'Error! ' . $e->getMessage() . ' // Linea-> ' . $e->getLine();
                    }
                    if (!$user) {
                        $val->errors['password'] = 'No existe usuario en la base de datos.<br>';
                        $datos = [
                            'email' => $_POST['login'],
                        ];
                    } else {
                        $datos = [
                            'email' => $_POST['login'],
                            'clave' => $_POST['password']
                        ];
                    }
                }
            }
            if ($val->errors) {
                echo $this->view->render('usuarios/login_form',
                    ['errors' => $val->errors, 'datos' => $datos]);

            } else {

                Session::init();
                Session::set('Id', $user->id);
                Session::set('Nick', $user->nickname);
                Session::set('Nombre', $user->nombre);
                Session::set('Rol', $user->rol);

                header('location: /usuarios/index');
                // $dato = "Has iniciado sesión como usuario: " . Session::get('Nick') . ".";

                // echo $this->view->render('usuarios/index',['datos' => $dato]
                //     );


                //  echo '<br>';
            }

        }else{
            echo $this->view->render('usuarios/login_form');
        }

    }
}