<?php ($this->layout('layout')) ?>

<?php foreach ($categorias as $cat) : ?>
    <div class="banner">
        <ul style="list-style-type:none;">
            <li>Nombre:</li>
            <li class="nombre">&nbsp;&nbsp; <?= $cat->nombre ?></li>
            <li>Descripcion:</li>
            <li class="descripcion">&nbsp;&nbsp;<?= $cat->descripcion ?></li>
        </ul>
        <a class="btn" href="/categorias/todos/">Volver</a>
    </div>
<?php endforeach; ?>
