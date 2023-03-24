<h1 class="nombre-pagina">Recuperar cuenta</h1>
<p class="descripcion-pagina">Ingresa tu nuevo password</p>
<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<?php if($error) return; ?>
<form action="" method="POST" class="formulario">
  <div class="campo">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Tu password"/>
  </div>

  <input type="submit" class="boton" value="Recuperar">
</form>

<div class="acciones">
  <a href="/">Iniciar sesion</a>
  <a href="/crear-cuenta">Aun no tienes una cuenta, crea una</a>
</div>