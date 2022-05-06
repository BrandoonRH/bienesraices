<?php 

function conectDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'bienesraices'); 
    
    if (!$db) {
        echo "Error no se pudo conectar"; 
        exit;
    }

    return $db; 
}