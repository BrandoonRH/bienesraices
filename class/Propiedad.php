<?php 

namespace App; 

class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades'; 
    protected static $columnasDB = ['titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    public $id; 
    public $titulo; 
    public $precio; 
    public $imagen;
    public $descripcion; 
    public $habitaciones; 
    public $wc; 
    public $estacionamiento; 
    public $creado; 
    public $vendedorId; 

    public function __construct($args = [])
    {
        $this->id = $args['$id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d'); 
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar(){
        //Verifico que no esten vacios los campos de los inputs
   if(!$this->titulo){
       self::$errores [] = "Debe añadir un Titulo"; 
       }
       if(!$this->precio){
           self::$errores [] = "Debe añadir un Precio"; 
       }
       if( strlen($this->descripcion) < 50 ){
           self::$errores [] = "La descripción es Obligatoria y debe tener al menos 50 caracteres"; 
       }
       if(!$this->habitaciones){
           self::$errores [] = "Debe añadir la cantidad de habitaciones"; 
       }
       if(!$this->wc){
           self::$errores [] = "Debe añadir la cantidad de baños"; 
       }
       if(!$this->estacionamiento){
           self::$errores [] = "Debe añadir la cantidad de estacionamientos"; 
       }
       if(!$this->vendedorId){
           self::$errores [] = "Debe añadir el vendedor"; 
       }
       if(!$this->imagen){
           self::$errores [] = "La Imagen de la propiedad es Obligatoria"; 
       }
   
       return self::$errores; 
   
   }






}