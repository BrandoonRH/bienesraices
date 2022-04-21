<?php

require 'includes/config/database.php'; 
$db = conectDB(); 

$queryConsulta = "SELECT * FROM propiedades LIMIT ${limiteAnuncios}"; 

$resultadoConsulta = mysqli_query($db, $queryConsulta); 



?>

<div class="contenedor-anuncios">

<?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
<div class="anuncio">
   
        <img loading="lazy" src="/bienesraices/images/<?php echo $propiedad['imagen']; ?>" alt="anuncio">
   

        <div class="contenido-anuncio">
        <h3><?php echo $propiedad['titulo']; ?></h3>
        <p><?php echo substr($propiedad['descripcion'], 0, 100); ?></p>
        <p class="precio">$ <?php echo $propiedad['precio']; ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad['wc']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad['estacionamiento']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p><?php echo $propiedad['habitaciones']; ?></p>
            </li>
        </ul>

        <a href="/bienesraices/anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">
            Ver Propiedad
        </a>
    </div><!--.contenido-anuncio-->
</div><!--anuncio-->
<?php endwhile; 
mysqli_close($db);
?>

</div> <!--.contenedor-anuncios-->