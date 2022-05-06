<?php
require '../../includes/app.php';

use  App\Propiedad; 
use  App\Vendedor; 
use Intervention\Image\ImageManagerStatic as Image;

$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

$propiedad = new Propiedad();
$vendedores = Vendedor::all(); 


$errores = Propiedad::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Creamos la Instancia 
    $propiedad = new Propiedad($_POST['propiedad']); 

    //Generar nombre unico para las imagenes 
    $nameImages = md5( uniqid( rand(), true ) ) . ".jpg";
     
    //Setear Imagen 
    //Realizar un resize a la Imagen con Intervention 
    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600); 
        $propiedad->setImagen($nameImages);
    }
   
  
    //Validar
    $errores = $propiedad->validar(); 

    
        if(empty($errores)){
        //Crear la Carpeta para subir las imagenes
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES); 
        }
        //Guardar la Imagen enn el Servidor 
        $image->save(CARPETA_IMAGENES . $nameImages);
        //Guardamos los Datos con la instacian 
        $propiedad->guardar();   
    }
}

incluirTemplate('header');
?>

<main>
    <h1>Crear</h1>
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

    <input type="submit" value="Crear Propiedad" class="boton boton-verde">
</form>


<?php 
incluirTemplate('footer');
?>