<?php $this->layout('layout') ?>
<?php use Mini\Core\Session;

Session::init();
?>
<div class="banner">
    <?php if (!$_SESSION) { ?>
        <div class="navigation">
            <h2>No estás registrado</h2>
        </div>
    <?php } else { ?>
        <div class="navigation">
            <h4>Todos los productos</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Borrar</th>
                    <th scope="col">Editar</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($productos) == 0) { ?>
                    <p>No tenemos productos en la Base de Datos</p>
                <?php } else { ?>
                    <p>Tenemos <?= count($productos) ?> en la base de datos</p>
                    <tr>
                    <?php foreach ($productos as $producto) { ?>
                        <td>
                            <div><?= $producto->nombre ?></div>
                        </td>
                        <td>
                            <div><?= $producto->marca ?></div>
                        </td>
                        <td>
                            <div><?= $producto->modelo ?></div>
                        </td>
                        <td>
                            <div><?= $producto->categoria ?></div>
                        </td>
                        <td>
                            <div><?= $producto->descripcion ?></div>
                        </td>
                        <td>
                            <div><img src="<?= '../../img/productos/' . $producto->imagenes ?>" alt="" width="40" height="30"/></div>
                        </td>
                        <td>
                            <div><a href="/productos/delete/<?= $producto->id ?>">Borrar</a></div>
                        </td>
                        <td>
                            <div><a href="/productos/editar/<?= $producto->id ?>">Editar</a></div>
                        </td>
                        </tr>
                    <?php }
                } ?>
                <td>
                    <div><a href="/productos/borratodo/<?= Session::get('Rol') ?>">Borrar todos</a></div>
                </td>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
