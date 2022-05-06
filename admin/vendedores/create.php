<?php
require '../../includes/app.php';
use App\Vendedor;

$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

$vendedor = new Vendedor(); 

//mensajes de Errores 
$errores = Vendedor::getErrores(); 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $vendedor = new Vendedor($_POST['vendedor']); 
    $errores = $vendedor->validar(); 
    if(empty($errores)){
        
        $vendedor->guardar();   
    }
}

incluirTemplate('header');
?>

<main>

    <h1>Registrar Vendedor</h1>
   <div class="contenedor">
      <a href="/bienesraices/admin/" class="boton boton-verde">Volver..</a>
   </div>

   <?php foreach($errores as $error): ?>
        <div class="alerta error">
           <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
   
</main>

<form action="/bienesraices/admin/vendedores/create.php" class="formulario" method="POST" >

<?php include '../../includes/templates/formulario_vendedores.php'?>

    <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
</form>

<?php 
incluirTemplate('footer');
?>