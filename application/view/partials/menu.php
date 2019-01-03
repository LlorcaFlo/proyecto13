<?php   use Mini\Core\Session;
Session::init()
?>

<div class="navigation">
    <!--Estos enlaces llevan al controlador y al método, si está vacio, irá directamente al index...-->
    <a href="<?php echo URL; ?>">Inicio</a>
    <a href="<?php echo URL; ?>productos">Productos</a>
    <a href="<?php echo URL; ?>categorias">Categorias</a>
    <a href="<?php echo URL; ?>preguntas/crear">Crear pregunta</a>
</div>