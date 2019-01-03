<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?= $titulo ?? 'Mini3' ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->
    <!-- CSS -->
    <link href="<?php echo URL; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
</head>
<body>
<!--Una cabecera-->
<?php $this->insert('header/header') ?>

<!--Dos navbar fijos-->
<?php $this->insert('navbar/navbar2') ?>
<?php $this->insert('navbar/navbar') ?>

<!--Método dado por la librería plates-->
<?= $this->section('content') ?>
<!--Pie de la página-->
<?php $this->insert('footer/footer') ?>

<!-- jQuery, loaded in the recommended protocol-less way -->
<!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
<script>
    var url = "<?php echo URL; ?>";
</script>

<!-- our JavaScript -->
<script src="<?php echo URL; ?>js/application.js"></script>
</body>
</html>