<?php
require '../../includes/functions.php';
$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

incluirTemplate('headerCRUD');
?>

<main>
    <h1>Eliminar</h1>
</main>

<?php 
incluirTemplate('footer');
?>