<?php

use \Mini\Model\Categoria;

$cat = new Categoria();
$categorias = $cat->getAllASC();

?>

<select class="form-control" name="categoria">
    <?php if (count($categorias) == 0) :
        $categoria = 'No existen categorias';
        echo '<option>' . " $categoria " . '</option>'; ?>
    <?php else : ?>
        <?php foreach ($categorias as $categoria):
            $categoria = ucfirst($categoria['nombre']);
            echo '<option>' . " $categoria " . '</option>';
            ?>
        <?php endforeach; ?>
    <?php endif; ?>
</select>
