<?php

require 'app.php';

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

