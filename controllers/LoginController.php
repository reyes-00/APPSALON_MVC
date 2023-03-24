<?php

namespace Controllers;

use Clases\Email;
use MVC\Router;
use Model\Usuario;

class LoginController{

  public static function login(Router $router){
    $usuario = new Usuario;
    $alertas = $usuario->getAlertas();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validaLogin();
      // debuguear($usuario->email);
      if(empty($alertas)){
        $auth = Usuario::where("email", $usuario->email);
        
        if($auth){
          if($auth->comprobarPasswordAndVerificado($usuario->password)){
            if(!isset($_SESSION)){
              session_start();
            }
            $_SESSION['nombre'] = $auth->nombre . " ". $auth->apellido;
            $_SESSION['id'] = $auth->id;
            $_SESSION['email'] = $auth->email;
            $_SESSION['login'] = true;
            $_SESSION['admin'] = $auth->admin;

            if($_SESSION['admin'] === "1"){
              // debuguear("Es admin");
              header("Location: /admin");
            }else{
              header("Location: /crear-cita");
            }
          }

        }else{
          Usuario::setAlerta('error','El correo es incorrecto');
        }
      }
    }
    
    $alertas = Usuario::getAlertas(); 
    $router->render('auth/login',[
      'alertas' => $alertas,
    ]);
  }
  public static function logout(){
    
      session_start();  
      $_SESSION = [];
     
      header('Location: /');
    
  }
  public static function olvide(Router $router){
    $alertas = [];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $auth = new Usuario($_POST);
      $alertas = $auth->validaOlvide();

      if(empty($alertas)){
        $usuario = Usuario::where('email', $auth->email);
        if($usuario && $usuario->confirmado === "1"){
          // Generar token
          $usuario->crearToken();
          $usuario->guardar();
          
          // Enviar el email

          $email = new Email($usuario->nombre,$usuario->email,$usuario->token);

          $email->enviarInstrucciones();

          Usuario::setAlerta('exito', 'Revisa tu email');

        }else{
           Usuario::setAlerta('error', 'Correo no encontrado');
        }
      }
    }
    $alertas = Usuario::getAlertas();
    $router->render('auth/olvide',[
      'alertas'=>$alertas,
    ]);
  }
  public static function recuperar(Router $router){
    $alertas = [];
    $error = false;
    $token = s($_GET['token']);
    $user =  Usuario::where('token',$token);

    if(!$user){
      Usuario::setAlerta('error','El token no es valido');
      $error = true;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validaPassword();
      
      if(empty($alertas)){
        $user->token = null;
        $user->id = intval( $user->id);
        $user->password = null;
        $user->password = $usuario->password;
        $user->hashPassword();
        
        $resultado = $user->guardar();
        
       
        if($resultado){
          header("Location: /");
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/recuperar',[
      'alertas'=>$alertas ,
      'error'=>$error
    ]);
  }
  public static function crear(Router $router){
    $usuario = new Usuario();
    $alertas =$usuario->getAlertas();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validar();
      
      if(empty($alertas)){
        // Verificar que el usuario no exista
        $existe = $usuario->existeUsuario();
        if($existe->num_rows){
          $alertas = $usuario->getAlertas();
        }else{
          // hashear password
          $usuario->hashPassword();
          $usuario->crearToken();
          $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
          $email->enviarConfirmacion();
          $resultado = $usuario->guardar();

          
          if($resultado){
            header("Location: /mensaje");
          }
        }
      }
    }
    $router->render('auth/crear-cuenta',[
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }

  public  static function mensaje(Router $router){
    $router->render('auth/mensaje',[

    ]);
  }

  public  static function confirmar(Router $router){
    $token = s($_GET['token']);
    
    $usuario = Usuario::where('token',$token);
    if(empty($usuario)){
      Usuario::setAlerta('error','El token no es valido');
    
    }else{
      $usuario->confirmado = "1";
      $usuario->token = null;
      $usuario->guardar();
      Usuario::setAlerta('exito','Cuenta comprobada correctamente');
      
    }

    $alertas = Usuario::getAlertas();
 
    
    $router->render('auth/confirmar',[
      'alertas' => $alertas,
    ]);
  }

}

?>