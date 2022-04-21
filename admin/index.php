<?php
require '../includes/functions.php';

$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

$resultadoCreate = $_GET['resultado'] ?? null;

incluirTemplate('header');
?>

<main>

    <h1>Administrador de Bienes Raices</h1>

    <?php if( intval($resultadoCreate) === 1 ): ?>
      <p class="alerta exito">Registro Exitoso</p>
    <?php elseif( intval($resultadoCreate) === 2 ): ?>  
      <p class="alerta exito">Actualización Exitosa</p>
      <?php elseif( intval($resultadoCreate) === 3 ): ?>  
      <p class="alerta exito">Eliminación Exitosa</p>
    <?php endif; ?>


    <div class="contenedor-enlaces-admin">
        <a href="/bienesraices/admin/propiedades/create.php" class="boton boton-verde">Crear Propiedad</a>

        <a href="/bienesraices/admin/propiedades/show.php" class="boton boton-verde">Ver Propiedades</a>

        <a href="#" class="boton boton-verde">Actualizar Propiedad</a>
        
        <a href="#" class="boton boton-verde">Eliminar Propiedad</a>
    </div>
</main>

<?php 
incluirTemplate('footer');
?>