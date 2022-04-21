<?php
require '../../includes/functions.php';

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


require '../../includes/config/database.php';
$conexionDB = conectDB();

$consultaPropiedad = "SELECT * FROM propiedades WHERE id = ${idPropiedad}";
$respuestaPropiedad = mysqli_query($conexionDB, $consultaPropiedad); 
$propiedad =  mysqli_fetch_assoc($respuestaPropiedad); 


$consulta = "SELECT * FROM vendedores";
$respuestaConsulta = mysqli_query($conexionDB, $consulta); 


$errores = [];

$titulo = $propiedad['titulo']; 
$precio = $propiedad['precio'];;
$imagenPropiedad = $propiedad['imagen'];;
$descripcion = $propiedad['descripcion'];;
$habitaciones = $propiedad['habitaciones'];;
$wc = $propiedad['wc'];;
$estacionamiento = $propiedad['estacionamiento'];;
$vendedorId = $propiedad['vendedorId'];;


if($_SERVER['REQUEST_METHOD'] === 'POST'){
 
    $titulo = mysqli_real_escape_string($conexionDB, $_POST['titulo']); 
    $precio = mysqli_real_escape_string($conexionDB,  $_POST['precio']);
    $descripcion = mysqli_real_escape_string($conexionDB, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($conexionDB, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($conexionDB,  $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($conexionDB,  $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($conexionDB,  $_POST['vendedor']);
    $creado = mysqli_real_escape_string($conexionDB, date('Y/m/d'));

    $imagen = $_FILES['imagen']; 

    if(!$titulo){
    $errores [] = "Debe añadir un Titulo"; 
    }
    if(!$precio){
        $errores [] = "Debe añadir un Precio"; 
    }
    if( strlen($descripcion) < 50 ){
        $errores [] = "Debe añadir una DEscripción mayor a la ingresada"; 
    }
    if(!$habitaciones){
        $errores [] = "Debe añadir la cantidad de habitaciones"; 
    }
    if(!$wc){
        $errores [] = "Debe añadir la cantidad de baños"; 
    }
    if(!$estacionamiento){
        $errores [] = "Debe añadir la cantidad de estacionamientos"; 
    }
    if(!$vendedorId){
        $errores [] = "Debe añadir el vendedor"; 
    }
    $medida = 1000 * 1000; 
    if ($imagen['size'] > $medida) {
        $errores [] = "La Imagen es muy Pesada"; 
    }

    if(empty($errores)){
    
        $carpetaImagenes = '../../images/';

        if(!is_dir($carpetaImagenes)){
          mkdir($carpetaImagenes); 
        }

        $nameImages = '';
        
        if($imagen['name']){

         unlink($carpetaImagenes . $propiedad['imagen']);
         $nameImages = md5( uniqid( rand(), true ) ) . ".jpg";
         move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nameImages);

        }else{
            $nameImages = $propiedad['imagen'];
        }
    
        
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nameImages}', descripcion = '${descripcion}', habitaciones = ${habitaciones},
                  wc = ${wc},  estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${idPropiedad}";

        
       $resultadoUpdate = mysqli_query($conexionDB, $query);

        if($resultadoUpdate){
        header('Location: /bienesraices/admin/?resultado=2');
        }
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
    <fieldset>
        <legend>Información General</legend>

        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" id="titulo" placeholder="Titulo de la Propiedad" value="<?php echo $titulo ?>">
        
        
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio?>">

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

        <img src="/bienesraices/images/<?php echo $imagenPropiedad ?>" alt="" class="image-update">

        <label for="descripcion">Descripción: </label>
        <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>

    </fieldset>

    <fieldset>
        <legend>Información de la Propiedad</legend>

        <label for="habitaciones">Habitaciones:</label>
        <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones ?>">

        <label for="wc">Baños:</label>
        <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc ?>">

        <label for="estacionamiento">Estacionamiento:</label>
        <input type="number" name="estacionamiento" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento ?>">

    </fieldset>

    <fieldset>
        <legend>Vendedor</legend>
        
        <label for="vendedor">Seleccione el Vendedor de la Propiedad</label>
        <select name="vendedor" >
            <option value="">---Seleccione---</option>

            <?php while($vendedor = mysqli_fetch_assoc($respuestaConsulta)) : ?>

            <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id'] ?>">
            <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'] ?> 
            </option>

            <?php endwhile; ?>

        </select>
    </fieldset>

    <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

</form>


<?php 
mysqli_close($conexionDB);
incluirTemplate('footer');
?>