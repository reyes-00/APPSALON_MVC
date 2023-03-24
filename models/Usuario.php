<?php

namespace Model;

class Usuario extends ActiveRecord{

  protected static $tabla = 'usuarios';

  protected static $columnasDB = ['id','nombre','apellido','telefono','email','confirmado','password','admin','token'];
 

  public $id;
  public $nombre;
  public $apellido;
  public $telefono;
  public $email;
  public $confirmado;
  public $password;
  public $admin;
  public $token;

  public function __construct($args = []){
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->confirmado = $args['confirmado'] ?? '0';
    $this->password = $args['password'] ?? '';
    $this->admin = $args['admin'] ?? '0';
    $this->token = $args['token'] ?? null;
    
  }

  public function validar()
  {
    if (!$this->nombre){
      self::$alertas ['error'][] = "El nombre es requerido";

    }
    if (!$this->apellido){
      self::$alertas ['error'][] = "El apellido es requerido";

    }
    if (!$this->telefono){
      self::$alertas ['error'][] = "El telefono es requerido";

    }
    if (!$this->email){
      self::$alertas ['error'][] = "El email es requerido";

    }
    if (!$this->password){
      self::$alertas ['error'][] = "El password es requerido";
      
    }
    
    if(strlen($this->password) < 6 ){
      
      self::$alertas ['error'][] = "El password debe ser mayor a seis caracteres";
    }
    return self::$alertas;
  }

  public function validaLogin(){
    
    if (!$this->email){
      self::$alertas ['error'][] = "El email es requerido";

    }
    if (!$this->password){
      self::$alertas ['error'][] = "El password es requerido";
    } 

    return self::$alertas;
  }

  public function validaOlvide(){
    if (!$this->email){
      self::$alertas ['error'][] = "El email es requerido";

    }
    return self::$alertas;
  }
  public function validaPassword(){
    if (!$this->password){
      self::$alertas ['error'][] = "El password es requerido";
    }
    if(strlen($this->password)< 6){
      self::$alertas ['error'][] = "El password debe ser mayor a 6 caracteres";
    }
    return self::$alertas;
  }

  public function existeUsuario(){
    $query = "SELECT * FROM "; 
    $query .= self::$tabla;
    $query .= " WHERE email = '";
    $query .= "$this->email' LIMIT 1";
    
    $resultado = self::$db->query($query);

    if($resultado->num_rows){
      Usuario::setAlerta('error','El correo ya existe');
    }

    return $resultado;
  }

  public function hashPassword(){
    $this->password =password_hash($this->password, PASSWORD_BCRYPT);
    
  }
  public function crearToken(){
    $this->token = uniqid();
  }

  public function comprobarPasswordAndVerificado($password){
    $resultado = password_verify($password,$this->password);

    if(!$resultado || !$this->confirmado){
      // confirmacion
      Usuario::setAlerta('error','El password es incorrecto o tu cuenta no ha sido confirmada');
      
    }else{
      echo "SIscomprobar";

    }
    return true;
  }


  
}

?>