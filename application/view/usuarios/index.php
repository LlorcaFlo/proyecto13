<?php use Mini\Core\Session;

$this->layout('layout');

Session::init();

if (Session::get('Rol') == 'Jefe') {
    $this->insert('partials/bannerjefes', ['user' => Session::get('Nick'), 'dato' => Session::get('Rol')]);
}
if (Session::get('Rol') == 'Empleado') {
    $this->insert('partials/bannerempleados', ['user' => Session::get('Nick'), 'dato' => Session::get('Rol')]);
}
if (Session::get('Rol') == 'Usuario') {
    $this->insert('partials/bannerusuarios', ['user' => Session::get('Nick'), 'dato' => Session::get('Rol')]);
}

?>

