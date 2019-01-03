<?php use Mini\Core\Session;

Session::init()
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="navbar-brand" href="<?php echo URL; ?>">Inicio</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" href="<?php /*echo URL; */ ?>productos">Productos<span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?php /*echo URL; */ ?>categorias" id="navbarDropdown"
                   role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Categorias
                </a>-->
            <!--            <div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
            <!--                <a class="dropdown-item" href="#">Action</a>-->
            <!--                <a class="dropdown-item" href="#">Another action</a>-->
            <!--                <div class="dropdown-divider"></div>-->
            <!--                <a class="dropdown-item" href="#">Something else here</a>-->
            <!--            </div>-->
            <!--            </li>-->
            <li class="nav-item">
                <?php if ($_SESSION) { ?>
                    <a class="nav-link disabled" href="<?php echo URL; ?>usuarios" tabindex="-1" aria-disabled="true">Página
                        Propia</a>
                <?php } ?>
            </li>
        </ul>
        <form action="<?php echo URL; ?>productos/buscador" method="post">
            <select name="select" id="">
                <option value="Nombre">Nombre</option>
                <option value="Marca">Marca</option>
                <option value="Categoria">Categoria</option>
            </select>
            <input type="text" name="buscador" placeholder="Busqueda">
            <button class="btn" type="submit" name="btn-buscador">Busqueda</button>
        </form>
        <?php if (!$_SESSION) { ?>
            <a class="nav-link disabled" href=" <?php echo URL; ?>login">Login</a>
            <a class="nav-link disabled" href="<?php echo URL; ?>registro">Registro</a>
        <?php } ?>
        <?php if ($_SESSION) { ?>
            <a class="nav-link disabled" href="<?php echo URL; ?>usuarios/cierrasesion">Cierra Sesión</a>
        <?php } ?>
    </div>
</nav>