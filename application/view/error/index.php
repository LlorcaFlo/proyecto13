<!--Método dado por la librería plates, le indicamos que use una vista en concrero-->
<?php $this->layout('layout-error', ['titulo' => 'Error']); ?>

<div class="banner">
    <h1 style="color: red">ERROR</h1>
    <p>Esta es la página de error. Se mostrará cuando no exista una página (= controlador / método).</p>
</div>

