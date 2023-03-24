<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario</p>
<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<form action="/crear-cuenta" method="POST" class="formulario">
  <div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo s($usuario->nombre); ?>">
  </div>
  <div class="campo">
    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" id="apellido" placeholder="Tu apellido" value="<?php echo s($usuario->apellido); ?>">
  </div>
  <div class="campo">
    <label for="telefono">Telefono</label>
    <input type="number" name="telefono" id="telefono" placeholder="Tu telefono" value="<?php echo s($usuario->telefono); ?>">
  </div>
  <div class="campo">
    <label for="email">Tu email</label>
    <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo s($usuario->email); ?>">
  </div>
  <div class="campo">
    <label for="password">Tu password</label>
    <input type="password" name="password" id="password" placeholder="Tu password">
  </div>
  <input type="submit" class="boton" value="Enviar">
</form>

<div class="acciones">
  <a href="/">Iniciar Sesion</a>
  <a href="/olvide">Recuperar Contraseña</a>
</div>