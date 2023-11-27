<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB =['id', 'nombre', 'email', 'password', 'token',
    'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        
    }

    //validar Login de usuario
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es Obligario';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no valido';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El Password No puede ir vacio';
        }
        
        return self::$alertas;

        
    }

    //Validacion para cuentas Nuevas
    public function validarNuevaCuenta() {
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligario';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es Obligario';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El Password No puede ir vacio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'Los Passwords son diferentes';
        }

        return self::$alertas;

    }

    public function varidar_perfil(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre es Obligario';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Email es Obligario';
        }
        return self::$alertas;

    }
    //hashea el password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

    }
    
    //Generar un Token
    public function crearToken(){
        $this->token = uniqid();
    }

    public function validarEmail(){
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no valido';
        }

        return self::$alertas;

    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El Password No puede ir vacio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;

    }

    public function nuevo_password(){
        if(!$this->password_actual){
            self::$alertas['error'][] = 'El password Actual no puede ir Vacio';
        }
        if(!$this->password_nuevo){
            self::$alertas['error'][] = 'El password Nuevo no puede ir Vacio';
        }
        if(strlen($this->password_nuevo) < 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;

    }

    //Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password);
    }



}
?>