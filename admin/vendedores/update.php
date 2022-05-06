<?php
require '../../includes/app.php';
use App\Vendedor; 

$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

//Validar URL por ID Valido 
$idVendedor = $_GET['id']; 
$idVendedor = filter_var( $idVendedor, FILTER_VALIDATE_INT );

if(!$idVendedor){
    header('Location: /bienesraices/admin/');
}

$vendedor = Vendedor::find($idVendedor); 
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $args = $_POST['vendedor']; 
    $vendedor->sincronizar($args); 
    $errores = $vendedor->validar(); 
   
    
    if(empty($errores)){
      $vendedor->guardar(); 
    }
}


incluirTemplate('header');
?>

<main>
    <h1>Actualizar Vendedor(a)</h1>

   <div class="contenedor">
      <a href="/bienesraices/admin/" class="boton boton-verde">Volver..</a>
   </div>

</main>

<form action="" class="formulario" method="POST" >

<?php include '../../includes/templates/formulario_vendedores.php'?>

    <input type="submit" value="Actualizar Vendedor(a)" class="boton boton-verde">
</form>



<?php 
incluirTemplate('footer');
?>