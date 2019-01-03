<?php

use Mini\Core\Session;

//echo Session::get('Id');
$this->layout('layout');
?>

<form action="<?php echo URL; ?>usuarios/update" method="post">
    <div class="registro">
        <br>
        <h4>Edita Usuario</h4>
        <?php if (isset($variable)) { ?>
            <div>
                <h2 style="color:green;"><?php echo $variable ?></h2><br>
            </div>
        <?php } ?>
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
        <br><br>
        <button type="submit" value="Editar" name="Edita_user" class="form-control">Edita</button>
        <br><br>
    </div>
</form>

