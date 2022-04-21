<?php 
require 'includes/functions.php';
incluirTemplate('header');
?>

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <?php 

               $limiteAnuncios = 10; 
               
                include 'includes/templates/anuncios.php';
            ?>
    </main>

<?php 
incluirTemplate('footer');
?>