<h1 class="nombre-pagina">Panel de administracion</h1>

<?php
  include_once __DIR__ .'/../templates/barra.php';
?>
<div class="busqueda-citas">
  <form action="" class="formulario">
    <div class="campo">
      <label for="fecha">Fecha: </label>
      <input type="date" name="fecha" id="fecha" value="<?php echo $fecha;?>">
    </div>
  </form>
</div>
<?php if(count($citas) === 0): ?>
  <h2>No hay citas</h2>
<?php endif; ?>
<div class="citas-admin">
  <ul class="citas">
    <?php $citaId = 1; ?>
    <?php foreach($citas as $key => $cita):?>
     
      <?php if($citaId != $cita->id ) : ?>
        <?php $total = 0; ?>
        <li>
          <p>ID: <span><?php echo $cita->id;?></span></p>
          <p>Fecha: <span><?php echo $cita->hora;?></span></p>
          <p>Cliente: <span><?php echo $cita->cliente;?></span></p>
          <p>email: <span><?php echo $cita->email;?></span></p>
          <p>telefono: <span><?php echo $cita->telefono;?></span></p>
          
          <?php $citaId = $cita->id; ?>
          <h3>Servicios</h3>
        </li>
        <?php endif; ?>
        <?php $total += $cita->precio; ?>
        <p class="servicio">Servicio: <span><?php echo $cita->servicio." $". $cita->precio ;?></span></p>
        <?php 
          $actual = $cita->id; 
          $proximo = $citas[$key + 1]->id ?? 0;
          ?>
         <?php if(esUltimo($actual, $proximo)): ?>
            <p class="total">Total: <span><?php echo "$ $total"; ?> </span></p>

            <form action="/api/eliminar" method="POST">
             <input type="hidden" name="id" value="<?php echo $cita->id?>">
             <input type="submit" value="Eliminar" class="boton boton-eliminar"> 
            </form>
    <?php endif;?>
    <?php endforeach;?>
  </ul>
</div>

<?php
  $script = "<script src = 'build/js/buscador.js'></script>";
?>