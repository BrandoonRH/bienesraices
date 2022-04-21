<?php 
$idPropiedadVer = $_GET['id']; 
$idPropiedadVer = filter_var( $idPropiedadVer, FILTER_VALIDATE_INT );

if(!$idPropiedadVer){
    header('Location: /bienesraices/');
}

require 'includes/config/database.php'; 
$db = conectDB(); 

//Consulto propiedad que el usuario me solicita ver 
$consultaPropiedadVer = "SELECT * FROM propiedades WHERE id = ${idPropiedadVer}";
$respuestaPropiedad = mysqli_query($db, $consultaPropiedadVer); 

if(!$respuestaPropiedad->num_rows){
    header('Location: /bienesraices/');
}
$propiedadVer =  mysqli_fetch_assoc($respuestaPropiedad); 



$titulo = $propiedadVer['titulo']; 
$precio = $propiedadVer['precio'];;
$imagenPropiedad = $propiedadVer['imagen'];;
$descripcion = $propiedadVer['descripcion'];;
$habitaciones = $propiedadVer['habitaciones'];;
$wc = $propiedadVer['wc'];;
$estacionamiento = $propiedadVer['estacionamiento'];;
$vendedorId = $propiedadVer['vendedorId'];;




require 'includes/functions.php';
incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $titulo ?></h1>

        <img loading="lazy" src="/bienesraices/images/<?php echo $imagenPropiedad; ?>" alt="imagen de la propiedad">
     

        <div class="resumen-propiedad">
            <p class="precio">$ <?php echo $precio ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $wc ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $estacionamiento ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $habitaciones ?></p>
                </li>
            </ul>

            <p>
             <?php echo $descripcion ?>
            </p>

        </div>
    </main>

<?php 
mysqli_close($db);
incluirTemplate('footer');
?>