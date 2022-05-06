<?php 

namespace App; 

class ActiveRecord{
//Base de Datos
protected static $conexionDB;
protected static $columnasDB = [''];
protected static $tabla = ''; 
//Errores 
protected static $errores = [];




 //Definir conexion a la Base de Dataos 
 public static function setDB($database){
     self::$conexionDB = $database;
 }



 public function sanitizarDatos(){
     $atributos = $this->atributos();
     $sanitizado = [];

     foreach($atributos as $key => $value){
       $sanitizado[$key] = self::$conexionDB->escape_string($value);
     }

     return $sanitizado; 

 }

 public function atributos(){
     $atributos = [];
     foreach(static::$columnasDB as $columna){
         if($columna === 'id') continue;
        $atributos[$columna] = $this->$columna; 
     }
     return $atributos; 
 }


 //Subir Imagen 
 public function setImagen($imagen){
     //Elimina la Imagen Previa 
     if(!is_null($this->id)){
       $this->borrarImagen(); 
     }
    if($imagen){
      $this->imagen = $imagen; 
    }
 }

 public function borrarImagen(){
     //Comprobar si existe el Archivo   
     $archivoExiste = file_exists(CARPETA_IMAGENES . $this->imagen); 
     if($archivoExiste){
      unlink(CARPETA_IMAGENES . $this->imagen);    
     }
 }

 public static function getErrores(){
    return static::$errores; 
 }

 public function validar(){
    static::$errores = []; 
     return static::$errores; 
 }

 //Sincronizar el Objeto en memoria
 public function sincronizar( $args = [] ){
    foreach($args as $key => $value ){
      if(property_exists($this, $key) && !is_null($value)){
       $this->$key = $value; 
      }
    }
 }
 public function guardar(){
     if(!is_null($this->id)){
      $this->actualizar();
     }else{
         $this->crear();
     }
     
 }
 //Método para Guardar Datos
 public function crear(){
     //Sanitizar los Datos 
     $atributos = $this->sanitizarDatos(); 
  
     //Insertar en la BASE DE DATOS 
     $query = "INSERT INTO " . static::$tabla ." ( "; 
     $query .= join(', ', array_keys($atributos)); 
     $query .= " ) VALUES (' ";
     $query .= join("', '", array_values($atributos));
     $query .= " ') ";
     
     $resultado = self::$conexionDB->query($query);
      if($resultado){
         //Redireccionar al Usuario 
      header('Location: /bienesraices/admin/?resultado=1');
      }
 }

 public function actualizar(){
     $atributos = $this->sanitizarDatos(); 

     $valores = []; 
     foreach($atributos as $key => $value){
       $valores[] = "{$key}='{$value}'";
     }
     
     $query = "UPDATE " . static::$tabla . " SET "; 
     $query .= join(', ', $valores ); 
     $query .= "WHERE id = '" . self::$conexionDB->escape_string($this->id) . "' ";
     $query .= " LIMIT 1";
     
     $resultadoActualizacion = self::$conexionDB->query($query); 
     if($resultadoActualizacion){
         header('Location: /bienesraices/admin/?resultado=2');
     }
 }
 public function eliminar(){
       //Eliminar Propiedad
     $queryEliminar = "DELETE  FROM ". static::$tabla ." WHERE id = " . self::$conexionDB->escape_string($this->id) . " LIMIT 1";
     $resultadoEliminar = self::$conexionDB->query($queryEliminar); 
     if($resultadoEliminar){
         $this->borrarImagen(); 
         header('Location: /bienesraices/admin/?resultado=3');
     }

 }

 //Listar Todas los Registros de la Base de Datoos
 public static function all(){
     $query = "SELECT * FROM " . static::$tabla; 
     $resultadoConsulta = self::consultarSQL($query);
     return $resultadoConsulta; 
 }

  //Listar una cantidad Limitada de Registros
  public static function get($cantidad){
    $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad; 
   
    $resultadoConsulta = self::consultarSQL($query);
    return $resultadoConsulta; 
}

 //Buscar un registro de la base de datos 
 public static function find($idPropiedad){
     $query = "SELECT * FROM ". static::$tabla ." WHERE id = ${idPropiedad}";
     $resultadoFind = self::consultarSQL($query); 
     return array_shift($resultadoFind); 
 }

 public static function consultarSQL($query){
    $resultado = self::$conexionDB->query($query);

    //Iterando los resultados
    $array = []; 
    while($registro = $resultado->fetch_assoc()){
       $array[] = static::crearObjeto($registro); 
    }
    //Liberar Memoria 
    $resultado->free(); 

    //retornar os resultados
    return $array;
 }

 protected static function crearObjeto($registro){
  $objeto = new static; 

  foreach($registro as $key => $value){
      if(property_exists($objeto, $key )){
         $objeto->$key = $value;
      }

  }
  return $objeto; 
 }

}