<?php
require '../../includes/app.php';
$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

incluirTemplate('header');
?>

<main>
    <h1>Eliminar Propiedad</h1>
</main>

<?php 
incluirTemplate('footer');
?>