<?php
$this->layout('layout');

use Mini\Core\Session;

Session::init();
?>
<?php if (Session::get('Rol') == 'Jefe') { ?>
    <div class="banner">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Email</th>
                <th scope="col">Nick</th>
                <th scope="col">Rol</th>
                <th scope="col">Editar</th>
                <th scope="col">Borrar</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($usuario

            as $key){ ?>

            <td>
                <div><?php echo $key->id; ?></div>
            </td>
            <td>
                <div><?php echo $key->nombre; ?></div>
            </td>
            <td>
                <div><?php echo $key->apellido; ?></div>
            </td>
            <td>
                <div><?php echo $key->email; ?></div>
            </td>
            <td>
                <div><?php echo $key->nickname; ?></div>
            </td>
            <td>
                <div><?php echo $key->rol; ?></div>
            </td>
            <td>
                <div><a href="/usuarios/editar/<?= $key->id ?>">Editar</a></div>
            </td>
            <td>
                <div><a href="/usuarios/borrar/<?= $key->id ?>">Borrar</a></div>
            </td>
            </tbody>
            <?php } ?>
        </table>
    </div>
<?php } else { ?>
    <table class="autorice">
        <thead>
        <tr>
            <th>
                <h6>No estas autorizado</h6>
            </th>
        </tr>
        </thead>
        <tbody>
        <td>
            <div><a href="<?php echo URL; ?>#">Volver</a></div>
        </td>
        </tbody>
    </table>
<?php } ?>

