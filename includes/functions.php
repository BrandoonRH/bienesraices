<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'functions.php');
define ('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenesBienesRaices/');

function incluirTemplate( string $nombre, bool $inicio = false){
 //echo TEMPLATES_URL . "/${nombre}.php";
    include TEMPLATES_URL . "/${nombre}.php";
}

function estadoAutenticado() : bool {
    session_start(); 

    $authEstado = $_SESSION['login'];

    if($authEstado){
      return true; 
    }
        return false;  
}
/*function estadoAutenticado(){
  session_start(); 

  if(!$_SESSION['login']){
    header('Location: /bienesraices/');
  }
}*/


function debugear($variable){
  echo "<pre>";
  var_dump($variable); 
  echo "</pre>"; 
  
  exit; 
}

//Escapar de HTML
function s($html) : string{
 $s = htmlspecialchars($html); 
 return $s;
}

 function validarTipoContenido($tipo){
  $tipos = ['vendedor', 'propiedad']; 
  return in_array($tipo, $tipos);  
}

function mostrarNotificacion($codigo){
  $mensaje = ''; 

  switch ($codigo) {
    case 1:
      $mensaje = "Registro Exitoso"; 
      break;
    case 2:
      $mensaje = "Actualización Exitosa"; 
      break;
        
    case 3:
      $mensaje = "Eliminación Exitosa"; 
      break;
    
    default:
      $mensaje = false; 
      break;
  }
  return $mensaje; 
}
