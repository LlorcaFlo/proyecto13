<?php $this->layout('layout') ?>
<?php use Mini\Core\Session;

Session::init()
?>
<?php
if ($_SESSION) { ?>
    <div class="login">
        <h6><?php echo '<br>' . Session::get('Nick') ?></h6>
        <h6 class="errorf">Ya has iniciado sesion, por favor, vuelva atras</h6>
    </div>
<?php } else { ?>
    <form action="<?php echo URL; ?>login" method="post">
        <div class="banner">
            <div class="login">
                <br>
                <h4>Identificate</h4>
                <p></p>
                <select name="select" id="select" class="form-control">
                    <option value="Nick">Nick</option>
                    <option value="Email">Email</option>
                </select>
                <br>
                <p>Nick o Email:</p>
                <input type="text" name="login" class="form-control"
                    <?php if (isset($datos['nick']))
                        echo ' value="' . $datos['nick'] . '"';
                    elseif (isset($datos['email']))
                        echo ' value="' . $datos['email'] . '"';
                    elseif (isset($datos['login']))
                        echo ' value="' . $datos['login'] . '"'; ?>
                ><br>
                <?php
                if (isset ($errors['login']))
                    echo '<span class="errorf">' . $errors['login'] . '</span>';
                ?>
                <p>Contraseña:</p>
                <input type="password" name="password" class="form-control"><br>
                <?php
                if (isset ($errors['password']))
                    echo '<span class="errorf">' . $errors['password'] . '</span>';
                ?><br>
                <button type="submit" value="Acceso" name="acceso_login" class="form-control">Acceso
            </div>
        </div>
    </form>
<?php } ?>



