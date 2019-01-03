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

class RegistroController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->titulo = 'Página Registro';
    }

    public function index()
    {
        $this->view->addData(['titulo' => 'Página Registro']);

        if (isset ($_POST['acceso_registro'])) {

            $datos = [];
            $val = new Validate();
            $user = new Usuario();

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
            if (!$val->vacio($_POST['email'])) {
                $val->errors['email'] = 'No hemos recibido el email.';
            } elseif (!$val->va_email($_POST['email'])) {
                $val->errors['email'] = 'No hemos recibido un email válido.';
                $datos['email'] = $_POST['email'];
            } elseif (!$val->uniqueEmail($_POST['email'])) {
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
                $val->errors['nickname'] = 'El nick ya está en uso, introduzca otro.';
                $datos['nickname'] = $_POST['nickname'];
            } else {
                $datos['nickname'] = $_POST['nickname'];
            }

            //CLAVES---- COMPROBARÁ QUE EXISTEN LAS CLAVES, SON VÁLIDAS Y SON IGUALES...
            if (!$val->vacio($_POST['clave1'])) {
                $val->errors['clave1'] = 'No hemos recibido la Contraseña.';
            } elseif (!$val->va_password($_POST['clave1'])) {
                $val->errors['clave1'] = 'La contraseña debe contener al menos 
                seis caracteres y entre ellos una mayúscula, una minúscula y un número.<br>';
            } elseif (!$val->passEquals($_POST['clave1'], $_POST['clave2'])) {
                $val->errors['clave1'] = 'Las contraseñas deben ser iguales.';
            } else {
                $datos['clave'] = $user->md5Clave($_POST['clave1']);
            }
            //AL SER USUARIO BÁSICO, SU ROL SERÁ USUARIO Y NO PODRÁ MODIFICARLO...
            $datos['rol'] = $_POST['rol'];

            if ($val->errors) {
                echo $this->view->render('usuarios/registro_form',
                    ['errors' => $val->errors, 'datos' => $datos]);


            } else {
                $user = new Usuario();
                try {
                    $ok = $user->insert($datos);
                } catch (PDOException $e) {
                    echo 'Error! ' . $e->getMessage() . ' // Linea-> ' . $e->getLine();
                }
                if (!$ok) {
                    echo $this->view->render('usuarios/registro_form');
                } else {
                    ?>
                    <div>
                        <h2>Usuario registrado</h2>
                    </div>
                    <?php
                    echo $this->view->render('usuarios/registro_form');
                }
            }
        } else {
            echo $this->view->render('usuarios/registro_form');
        }
    }
}
