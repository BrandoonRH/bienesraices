<?php
require '../../includes/functions.php';
$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

//Conexión a Base de Datos 
require '../../includes/config/database.php';
$conexionDB = conectDB();

//Consultar los Vendedores
$consulta = "SELECT * FROM vendedores";
$respuestaConsulta = mysqli_query($conexionDB, $consulta); 

/*$correo = "admin@admin.com/"; 
var_dump($correo);
$correoSanitizado = filter_var($correo, FILTER_SANITIZE_EMAIL); 
var_dump($correoSanitizado);
$correoValidado = filter_va7r($correoSanitizado, FILTER_VALIDATE_EMAIL); 
var_dump($correoValidado);*/

//Arreglo de los campos faltantes
$errores = [];

/*Creo las variables para poder utilizarlas en el formulario y no perder la infor 
Que el usuario ya tenia ingresada*/
$titulo = ''; 
$precio = '';
$imagen = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    /*echo "<pre>";
    var_dump($_POST);
    echo "</pre>";*/

    //De la super variable global de POST accedo a al información de cada campo en los input
    $titulo = mysqli_real_escape_string($conexionDB, $_POST['titulo']); 
    $precio = mysqli_real_escape_string($conexionDB,  $_POST['precio']);
    //$imagen = mysqli_real_escape_string($conexionDB, $_POST['imagen']);
    $descripcion = mysqli_real_escape_string($conexionDB, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($conexionDB, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($conexionDB,  $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($conexionDB,  $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($conexionDB,  $_POST['vendedor']);
    $creado = mysqli_real_escape_string($conexionDB, date('Y/m/d'));

    //Asignar la variable global FILES a una Imagen 
    $imagen = $_FILES['imagen']; 


    //Verifico que no esten vacios los campos de los inputs
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
    if(!$imagen['name'] || $imagen['error']){
        $errores [] = "La Imagen es Obligatoria"; 
    }

    //Validar Imagen por Tamaño (100 Kb máximo)
    $medida = 1000 * 1000; 

    if ($imagen['size'] > $medida) {
        $errores [] = "La Imagen es muy Pesada"; 
    }


    //Verifico que el array de errores no este vacio para continuar con el registro de la información 
    if(empty($errores)){
        
        //Crear Carpeta para Imagenes
        $carpetaImagenes = '../../images/';

        if(!is_dir($carpetaImagenes)){
          mkdir($carpetaImagenes); 
        }
        //Generar nombre unico para las imagenes 
        $nameImages = md5( uniqid( rand(), true ) ) . ".jpg";
    
        //Subir Imagenes
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nameImages);

      
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) 
        VALUES ('$titulo', '$precio', '$nameImages', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";

        //echo $query;

        $resultado = mysqli_query($conexionDB, $query);

        if($resultado){
            //Redireccionar al Usuario 
        header('Location: /bienesraices/admin/?resultado=1');
        
        }
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
    <fieldset>
        <legend>Información General</legend>

        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" id="titulo" placeholder="Titulo de la Propiedad" value="<?php echo $titulo ?>">
        
        
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio?>">

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

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

    <input type="submit" value="Crear Propiedad" class="boton boton-verde">

</form>


<?php 
incluirTemplate('footer');
?>