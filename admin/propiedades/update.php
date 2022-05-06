<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';

$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

//Validar URL por ID Valido 
$idPropiedad = $_GET['id']; 
$idPropiedad = filter_var( $idPropiedad, FILTER_VALIDATE_INT );

if(!$idPropiedad){
    header('Location: /bienesraices/admin/');
}

$propiedad = Propiedad::find($idPropiedad); 
$vendedores = Vendedor::all(); 


$errores = Propiedad::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $args = $_POST['propiedad']; 
    $propiedad->sincronizar($args); 
    $errores = $propiedad->validar(); 
    $nameImages = md5( uniqid( rand(), true ) ) . ".jpg";

    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600); 
        $propiedad->setImagen($nameImages);
    }

    if(empty($errores)){

        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image->save(CARPETA_IMAGENES . $nameImages);
        }
        
      $propiedad->guardar(); 
    }

}

incluirTemplate('header');
?>

<main>
    <h1>Actualizar</h1>
   <div class="contenedor">
   <a href="/bienesraices/admin/" class="boton boton-verde">Volver..</a>
   </div>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
           <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

</main>

<form action="" class="formulario" method="POST" enctype="multipart/form-data">
    
<?php include '../../includes/templates/formulario_propiedades.php'?>

    <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

</form>


<?php 

incluirTemplate('footer');
?>