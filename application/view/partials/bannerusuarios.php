<style>
    .btn {
        margin: 10px;
        padding: 10px;
    }
</style>
<?php
use Mini\Core\Session;
Session::init();
?>
<div class="banner">
    <h3><?= $user ?> <?= $dato?></h3>
    <div class="navigation">
        <br>
        <a class="btn" href="<?php echo URL; ?>usuarios/update/"<?php Session::get('Id')?>>Editar Usuario</a>
        <br>
        <a class="btn" href="">Ver Tus Mensajes</a>
        <br>
    </div>
</div>
