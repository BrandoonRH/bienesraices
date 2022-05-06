<?php
require '../includes/functions.php';

$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

$resultado = $_GET['resultado'] ?? null;

incluirTemplate('header');
?>

<!--PROPIEDADES ADMINISTRADOR-->
<main>

    <h1>Administrador de Bienes Raices</h1>

    <?php 
    $mensaje = mostrarNotificacion(intval($resultado)); 
     if($mensaje){  ?>
         <p class="alerta exito"><?php echo s($mensaje);  ?></p>
    <?php } ?> 


    <div class="contenedor-enlaces-admin">
        <a href="/bienesraices/admin/propiedades/create.php" class="boton boton-verde">Crear Propiedad</a>

        <a href="/bienesraices/admin/propiedades/show.php" class="boton boton-verde">Ver Propiedades</a>

        <a href="#" class="boton boton-verde">Actualizar Propiedad</a>
        
        <a href="#" class="boton boton-verde">Eliminar Propiedad</a>
    </div>

</main>


<!--VENDEDORES ADMINISTRADOR-->
<main>

    <h1>Administrador de Vendedores</h1>

    <div class="contenedor-enlaces-admin">
        <a href="/bienesraices/admin/vendedores/create.php" class="boton boton-verde">Registrar Vendedor</a>

        <a href="/bienesraices/admin/vendedores/show.php" class="boton boton-verde">Ver Vendedores</a>

        <a href="#" class="boton boton-verde">Actualizar Vendedor</a>
        
        <a href="#" class="boton boton-verde">Eliminar Vendedor</a>
    </div>

</main>

<?php 
incluirTemplate('footer');
?>