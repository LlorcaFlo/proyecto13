<?php $this->layout('layout'); ?>
<div class="banner">
    <div class="registro">
        <br>
        <form action="<?php echo URL; ?>productos/editar/<?= $datos['Id'] ?>" method="post" enctype="multipart/form-data">
            <h4>Edita Producto</h4>
            <?php if (isset($variable)) { ?>
                <div>
                    <h2 style="color:green;"><?php echo $variable ?></h2><br>
                </div>
            <?php } ?>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre"
                <?php
                if (isset($datos['nombre'])) {
                    echo ' value="' . $datos['nombre'] . '"';
                } ?>
            >
            <?php
            if (isset ($errors['nombre']))
                echo '<span class="errorf">' . $errors['nombre'] . '</span><br>';
            ?>

            <label for="modelo">Modelo del Producto</label>
            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo"
                <?php if (isset($datos['modelo']))
                    echo ' value="' . $datos['modelo'] . '"'; ?>>
            <?php if (isset ($errors['modelo']))
                echo '<span class="errorf">' . $errors['modelo'] . '</span><br>';
            ?>

            <label for="marca">Marca del producto</label>
            <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca"
                <?php if (isset($datos['marca']))
                    echo ' value="' . $datos['marca'] . '"'; ?>>
            <?php if (isset ($errors['marca']))
                echo '<span class="errorf">' . $errors['marca'] . '</span><br>';
            ?>

            <label for="categoria">Categorias</label>
            <select name="categoria" id="categoria" class="form-control">
                <?php foreach ($categorias as $cat): ?>
                    <option><?php echo $cat->nombre ?></option>
                <?php endforeach; ?>
                <?php if (isset($datos['categoria'])) { ?>
                    <option value="<?= $datos['categoria'] ?>" selected><?= $datos['categoria'] ?></option>
                <?php } ?>
            </select>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion" placeholder="Descripcion">
                <?php if (isset($datos['descripcion'])) {
                    echo $datos['descripcion'];
                } ?></textarea>
            <?php if (isset ($errors['descripcion']))
                echo '<span class="errorf">' . $errors['descripcion'] . '</span><br>';
            ?>

            <label for="precio">Precio</label>
            <input style="width:100px; margin:auto;" class="form-control" id="precio" name="precio" type="number"
                   step="any"
                <?php if (isset($datos['precio'])) {
                    echo ' value="' . $datos['precio'] . '"';
                } ?>>
            <?php if (isset ($errors['precio']))
                echo '<span class="errorf">' . $errors['precio'] . '</span><br>';
            ?>

            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" class="form-control" height="40px"/>

            <button type="submit" class="btn" name="edita_prod">Editar</button>
            <br><br>
    </div>
</div>