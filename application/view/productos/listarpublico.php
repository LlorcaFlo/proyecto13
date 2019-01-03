<?php $this->layout('layout', ['titulo' => 'Productos de ' . $titulo]) ?>

<div class="banner">
    <h4>Nuestros productos</h4>
    <?php if (count($productos) == 0) { ?>
    <h4>No tenemos productos en la Base de Datos</h4>
</div>
<?php } else { ?>
    <div class="banner">
        <div class="contenedor">
            <?php foreach ($random as $rand) { ?>
                <div class="colizda">
                    <br>
                    <h4>RECOMENDADOS</h4>
<!--                <h6>--><?php //echo $rand->id ?><!--</h6>-->
                    <p><?php echo $rand->nombre; ?></p>
                    <p><?php echo $rand->modelo ?></p>
                    <p><?php echo $rand->marca ?></p>
                    <h6><?php echo $rand->descripcion ?></h6>
                    <?php if (!$rand->imagenes) { ?>
                        <img href="../../img/productos/Error.png" alt="..." class="img-circle" hidden>
                    <?php } else {
                        ?>
                        <img class="img-circle" src="<?= '../../img/productos/' . $rand->imagenes ?>" width="180"
                             height="180"/>
                    <?php } ?>
                    <a class="btn" type="submit" href="/productos/ver/<?php echo $rand->id ?>">Ver</a>
                </div>
            <?php } ?>
            <div class="colmedio">
                <caption>Productos de <?php echo $titulo ?> </caption>
                <div>
                    <table class="table table-striped">
                        <tr>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Descripcion</th>
                        </tr>
                        <tr>
                            <?php foreach ($productos

                            as $prod) { ?>
                            <td><?php echo $prod->nombre; ?></td>
                            <td><?php echo $prod->marca; ?></td>
                            <td><?php echo $prod->modelo ?></td>
                            <td><?php echo $prod->precio . " "; ?>€</td>
                            <td><?php echo $prod->descripcion; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <div class="coldrch">
                <br>
                <h5>Nuestras Marcas</h5>
                <?php foreach ($marcas as $marca) { ?>
                    <p><a href=""><?php echo $marca->marca; ?></a></p>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>