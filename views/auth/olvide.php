<h1 class="nombre-pagina">Recuperar cuenta</h1>
<p class="descripcion-pagina">Ingresa tu correo</p>
<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<form action="/olvide" method="POST" class="formulario">
  <div class="campo">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="Tu email"/>
  </div>

  <input type="submit" class="boton" value="Recuperar">
</form>

<div class="acciones">
  <a href="/">Iniciar sesion</a>
  <a href="/crear-cuenta">Aun no tienes una cuenta, crea una</a>
</div>