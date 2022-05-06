<?php
require '../../includes/app.php';
use App\Vendedor;


$auth = estadoAutenticado(); 
if(!$auth){
    header('Location: /bienesraices/');
}

$vendedoresConsulta = Vendedor::all(); 

if($_SERVER['REQUEST_METHOD'] === 'POST' ){

    $id = $_POST['id']; 
    $id = filter_var($id, FILTER_VALIDATE_INT);
  
    if($id){
       $tipo = $_POST['tipo']; 
       if(validarTipoContenido($tipo)){
         if($tipo === 'vendedor'){
            $vendedorEliminar = Vendedor::find($id); 
            $vendedorEliminar->eliminar(); 
         }
       }
    }
  }
  
incluirTemplate('header');
?>

<main>
    <h1>Lista de Vendedores</h1>

    <div class="contenedor">
   <a href="/bienesraices/admin/" class="boton boton-verde">Volver..</a>
   </div>

   <h2>Vendedores</h2>
    <div class="contenedor">

       <table class="propiedades">
           <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>telefono</th>
                <th>Correo</th>
           </thead>
           <tbody><!---Mostramos los Datos-->
           <?php foreach( $vendedoresConsulta as $vendedor ) : ?>
               <tr> 
                   <!--Id -->
                   <td>
                    <?php echo $vendedor->id ?>
                   </td>
                <!--Nombre -->
                   <td> 
                   <?php echo $vendedor->nombre ?>
                   </td>

                   <!--Apellido-->
                   <td>
                   <?php echo $vendedor->apellido ?>
                   </td>

                   <!--Telefono-->
                   <td>
                    <?php echo $vendedor->telefono ?>
                   </td> 
                   
                   <!--Correo-->
                   <td>
                    <?php echo $vendedor->correo ?>
                   </td> 

                   <!--Acciones -->
                   <td>

                       <form action="" method="POST" class="w-100">
                          <input type="hidden" name="id" value=" <?php echo $vendedor->id ?>">
                          <input type="hidden" name="tipo" value="vendedor">
                         <input type="submit" class="boton-rojo-block" value="Eliminar">
                       </form>

                       <a href="/bienesraices/admin/vendedores/update.php?id= <?php echo $vendedor->id ?>" class="boton-amarillo-block">Actualizar</a>    
                   </td>

               </tr>
               <?php endforeach; ?>
           </tbody>
       </table>
    </div>
   
</main>

<?php 
incluirTemplate('footer');
?>