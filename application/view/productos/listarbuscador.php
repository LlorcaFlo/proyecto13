<?php $this->layout('layout', ['titulo' => 'Productos de ' . $titulo]) ?>

<div class="banner">
    <h4>Nuestros productos</h4>
    <?php if (count($productos) == 0) { ?>
    <h4>No tenemos coincidencias en la Base de Datos con <?php echo $titulo ?></h4>
</div>
<?php } else { ?>
    <div class="banner">
        <div class="container">
            <caption>Productos de <?php echo $titulo ?> </caption>
            <div>
                <table class="table table-striped">
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                    </tr>
                    <tr>
                        <?php foreach ($productos
                        as $prod) { ?>
                        <td><?php echo $prod->nombre; ?></td>
                        <td><?php echo $prod->marca; ?></td>
                        <td><?php echo $prod->modelo ?></td>
                        <td><?php echo $prod->categoria ?></td>
                        <td><?php echo $prod->precio . " "; ?>€</td>
                        <td><?php echo $prod->descripcion; ?></td>
                        <td><img src="<?= '../../img/productos/' . $prod->imagenes ?>" width="100" height="100" alt=""></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
