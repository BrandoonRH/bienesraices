<?php
require '../../includes/app.php';
$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

incluirTemplate('header');
?>

<main>
    <h1>Eliminar Vendedor</h1>

    <div class="contenedor">
    <a href="/bienesraices/admin/" class="boton boton-verde">Volver..</a>
   </div>

   
</main>

<?php 
incluirTemplate('footer');
?>