<?php ($this->layout('layout')) ?>

<?php if (!$_SESSION) { ?>
    <div class="container">
        <h2>No estás registrado</h2>
    </div>
<?php } else { ?>
    <div class="navigation">
        <h4>Todas las categorias</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Editar</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($categorias) == 0) { ?>
                <p>No tenemos productos en la Base de Datos</p>
            <?php } else { ?>
                <p>Tenemos <?= count($categorias) ?> en la base de datos</p>
                <tr>
                <?php foreach ($categorias as $cat) { ?>
                    <td>
                        <div><?= $cat->nombre ?></div>
                    </td>
                    <td>
                        <div><?= $cat->titulo ?></div>
                    </td>
                    <td>
                        <div><?= $cat->descripcion ?></div>
                    </td>
                    <td>
                        <div><a href="/productos/editar/<?= $cat->id ?>">Borrar</a></div>
                    </td>
                    </tr>
                <?php }
            } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
