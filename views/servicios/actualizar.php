<h1 class="nombre-pagina">Actualiza Servicios</h1>
<p class="descripcion-pagina">Actualiza tus servicios</p>
<?php
include_once __DIR__ . '/../templates/barra.php';
include __DIR__ . '/../templates/alertas.php';

?>

<form method="POST">
  <?php include_once __DIR__ . './formulario.php' ?>
  <input type="submit" value="Actualizar Servicio" class="boton">
</form>