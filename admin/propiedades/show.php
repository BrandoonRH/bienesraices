<?php
require '../../includes/functions.php';
$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

//Importar la conexión 
require '../../includes/config/database.php';
$conexionDB = conectDB();

//Escribir Query
$queryConsulta = "SELECT * FROM propiedades"; 

//Consultar la BD 
$resultadoConsulta = mysqli_query($conexionDB, $queryConsulta); 

//Codigo para Eliminar una Propiedad 
if($_SERVER['REQUEST_METHOD'] === 'POST' ){
  $id = $_POST['id']; 
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if($id){

     //Eliminar Archivo 
     $queryImagenEliminar = "SELECT imagen FROM propiedades WHERE id = ${id}";
     $resultadoImagen = mysqli_query($conexionDB, $queryImagenEliminar); 
     $propiedad = mysqli_fetch_assoc($resultadoImagen); 

     unlink('../../images/' . $propiedad['imagen']);



    //Eliminar Propiedad
   $queryEliminar = "DELETE  FROM propiedades WHERE id = ${id}";
   $resultadoEliminar = mysqli_query($conexionDB, $queryEliminar); 

   if($resultadoEliminar){
    header('Location: /bienesraices/admin/?resultado=3');
   }

  }
}

//Importamos tablate
incluirTemplate('header');
?>

<main>
    <h1>Lista de Bienes Raices</h1>
   
    <div class="contenedor">
     <a href="/bienesraices/admin/" class="boton boton-verde">Volver..</a>
    </div>

    <div class="contenedor">

       <table class="propiedades">
           <thead>
                <th>Codigo</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
           </thead>
           <tbody><!---Mostramos los Datos-->
           <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
               <tr> 
                   <!--Id -->
                   <td>
                    <?php echo $propiedad['id'] ?>
                   </td>
                <!--Titulo -->
                   <td> 
                   <?php echo $propiedad['titulo'] ?>
                   </td>

                   <!--Imagen -->
                   <td>
                     <img src="/bienesraices/images/<?php echo $propiedad['imagen']; ?>" alt="" class="imagen-tabla">
                   </td>

                   <!--Precio -->
                   <td>
                   $ <?php echo $propiedad['precio'] ?>
                   </td> 

                   <!--Acciones -->
                   <td>

                       <form action="" method="POST" class="w-100">
                          <input type="hidden" name="id" value=" <?php echo $propiedad['id'] ?>">
                         <input type="submit" class="boton-rojo-block" value="Eliminar">
                       </form>

                       <a href="/bienesraices/admin/propiedades/update.php?id= <?php echo $propiedad['id'] ?>" class="boton-amarillo-block">Actualizar</a>    
                   </td>

               </tr>
               <?php endwhile; ?>
           </tbody>
       </table>

    </div>
</main>

<?php 
//Cerramos Conexión 
mysqli_close($conexionDB);

incluirTemplate('footer');
?>