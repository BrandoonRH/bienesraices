<?php 

namespace App; 

class Vendedor extends ActiveRecord{
    protected static $tabla = 'vendedores'; 
    protected static $columnasDB = ['nombre', 'apellido', 'telefono', 'correo'];

    public $id; 
    public $nombre; 
    public $apellido; 
    public $telefono; 
    public $correo; 

    public function __construct($args = [])
    {
        $this->id = $args['$id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->correo = $args['correo'] ?? '';
       
    }

    public function validar(){
        //Verifico que no esten vacios los campos de los inputs
   if(!$this->nombre){
       self::$errores [] = "Debe añadir un Nombre"; 
       }
       if(!$this->apellido){
           self::$errores [] = "Debe añadir un Apellido"; 
       }
       if(!$this->telefono ){
           self::$errores [] = "Añadir Télefono"; 
       }
       if(!preg_match('/[0-9]{10}/', $this->telefono)){
          self::$errores [] = " Télefono NO Valido"; 
       }
       if(!$this->correo){
           self::$errores [] = "Añadir Correo"; 
       }
       if(!preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $this->correo)){
        self::$errores [] = " Correo NO valido"; 
       }
       
       return self::$errores; 
   
   }

}