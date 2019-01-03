<?php
/**
 * Created by PhpStorm.
 * User: josellorca
 * Date: 2018-12-26
 * Time: 01:16
 */
?>
<?php use Mini\Core\Session;

Session::init()
?>
<?php $this->layout('layout') ?>

<!--Podrá acceder al registro, siempre y cuando no esté registrado...
y siempre y cuando su Rol sea jefe, que podrá ingresar usuarios-->

<?php if (!$_SESSION OR isset($_SESSION) && Session::get('Rol') == 'Jefe') { ?>
    <div class="banner">
        <form action="<?php echo URL; ?>registro" method="post">
            <div class="registro">
                <br>
                <h4>Registrate</h4>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control"
                    <?php
                    if (isset($datos['nombre'])) {
                        echo ' value="' . $datos['nombre'] . '"';
                    } ?>
                >
                <?php
                if (isset ($errors['nombre']))
                    echo '<span class="errorf">' . $errors['nombre'] . '</span><br>';
                ?>

                <label for="apellido">Apellido</label><br>
                <input type="text" name="apellido" class="form-control"
                    <?php
                    if (isset($datos['apellido'])) {
                        echo ' value="' . $datos['apellido'] . '"';
                    } ?>
                >
                <?php
                if (isset ($errors['apellido']))
                    echo '<span class="errorf">' . $errors['apellido'] . '</span><br>';
                ?>

                <label for="email">Email</label><br>
                <input type="email" name="email" class="form-control"
                    <?php
                    if (isset($datos['email'])) {
                        echo ' value="' . $datos['email'] . '"';
                    } ?>
                >
                <?php
                if (isset ($errors['email']))
                    echo '<span class="errorf">' . $errors['email'] . '</span><br>';
                ?>

                <label for="nickname">Nick</label>
                <input type="text" name="nickname" class="form-control"
                    <?php
                    if (isset($datos['nickname'])) {
                        echo ' value="' . $datos['nickname'] . '"';
                    } ?>
                >
                <?php
                if (isset ($errors['nickname']))
                    echo '<span class="errorf">' . $errors['nickname'] . '</span><br>';
                ?>

                <label for="clave1">Clave</label>
                <input type="password" name="clave1" class="form-control">
                <?php
                if (isset ($errors['clave1']))
                    echo '<span class="errorf">' . $errors['clave1'] . '</span><br>';
                ?>

                <label for="clave2">Repetir Clave</label><br>
                <input type="password" name="clave2" class="form-control"><br>

                <!--Se podrá registrar como jefe, siempre y cuando
                sea un jefe quién acceda al registro...-->
                <?php
                if (Session::get('Rol') == 'Jefe') {
                    ?>
                    <label for="Rol">Rol</label><br>
                    <select name="rol">
                        <option>Empleado</option>
                        <option>Jefe</option>
                    </select>
                <?php } else { ?>
                    <label for="Rol" hidden>Rol</label><br>
                    <select name="rol" hidden>
                        <option>Usuario</option>
                    </select><br><br>
                <?php } ?>
                <button type="submit" value="Registro" name="acceso_registro" class="form-control">Registro</button>
                <br><br>
            </div>
    </div>
    </form>
<?php } else { ?>
    <div class="banner">
        <div class="container">
            <div class="form" style="width:300px; margin: auto; text-align: center;">
                <h3>No tienes acceso a esta zona.</h3>
                <h4>Ya estás registrado como: "<span style="color: red;"><?php echo Session::get('Rol') ?></span>"</h4>
            </div>
        </div>
    </div>

<?php } ?>



