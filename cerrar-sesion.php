<?php 
session_start(); 

$_SERVER = []; 

header('Location: /bienesraices/');

session_destroy(); 
?>