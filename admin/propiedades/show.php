<?php
require '../../includes/app.php';
use App\Propiedad;


$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

//Método para obtener las Propiedades 
$propiedadesConsulta = Propiedad::all(); 

//Codigo para Eliminar una Propiedad 
if($_SERVER['REQUEST_METHOD'] === 'POST' ){
    
  $id = $_POST['id']; 
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if($id){
    $tipo = $_POST['tipo']; 
    if(validarTipoContenido($tipo)){
      if($tipo === 'propiedad'){
         $propiedadEliminar = Propiedad::find($id); 
         $propiedadEliminar->eliminar(); 
      }
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
     <h2>Propiedades</h2>
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
           <?php foreach( $propiedadesConsulta as $propiedad ) : ?>
               <tr> 
                   <!--Id -->
                   <td>
                    <?php echo $propiedad->id ?>
                   </td>
                <!--Titulo -->
                   <td> 
                   <?php echo $propiedad->titulo ?>
                   </td>

                   <!--Imagen -->
                   <td>
                     <img src="/imagenesBienesRaices/<?php echo $propiedad->imagen; ?>" alt="" class="imagen-tabla">
                   </td>

                   <!--Precio -->
                   <td>
                   $ <?php echo $propiedad->precio ?>
                   </td> 

                   <!--Acciones -->
                   <td>

                       <form action="" method="POST" class="w-100">
                          <input type="hidden" name="id" value=" <?php echo $propiedad->id ?>">
                          <input type="hidden" name="tipo" value="propiedad">
                         <input type="submit" class="boton-rojo-block" value="Eliminar">
                       </form>

                       <a href="/bienesraices/admin/propiedades/update.php?id= <?php echo $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>    
                   </td>

               </tr>
               <?php endforeach; ?>
           </tbody>
       </table>
    </div>
</main>

<?php 
//Cerramos Conexión 

incluirTemplate('footer');
?>