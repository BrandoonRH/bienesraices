<?php 
require 'includes/app.php';
$conexionDB = conectDB(); 


$errores = []; 

if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
   /*echo "<pre>";
   var_dump($_POST);
   echo "</pre>";*/

   $emailUsuario =  mysqli_real_escape_string($conexionDB, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)); 
   $passwordUsuario = mysqli_real_escape_string($conexionDB, $_POST['password']);

   if(!$emailUsuario){
      $errores[] = "El Email es Obligatorio o no es Valido"; 
   }

   if(!$passwordUsuario){
    $errores[] = "El Password es Necesario"; 
   }

   if(empty($errores)){
    
    //Revisar si el usuario Existe
    $queryUsuario = "SELECT * FROM usuarios WHERE email = '${emailUsuario}' ";
    $resultadoConsulta = mysqli_query($conexionDB, $queryUsuario);

    

    if($resultadoConsulta -> num_rows){
       //Revisar si la Contrseña es Correcta
       $usuario = mysqli_fetch_assoc($resultadoConsulta);

      //Verificar si el Password es correcto 

      $auth = password_verify($passwordUsuario, $usuario['password']); 

     if($auth){
       //El Usuario esta Autenticado
    session_start(); 
    $_SESSION['usuarioNombre'] = $usuario['nombre']; 
    $_SESSION['usuarioApellido'] = $usuario['apellido']; 
    $_SESSION['login'] = true; 

    header('Location: /bienesraices/admin/');


     }else{
         $errores [] = "El Password es incorrecto"; 
     }

    }else{
          $errores[] = "El Usuario no existe"; 
    }
   }

}


incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

       <?php foreach($errores as $error): ?>
         <div class="alerta error">
             <?php echo $error; ?>
         </div>
        <?php endforeach; ?>


        <form class="formulario formulario-login" method="POST" >

            <fieldset class="fieldset-login">
                <legend>Email y Contrseña</legend>

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="email" name="email" required>

                <label for="password">Contraseña</label>
                <input type="password" placeholder="Tu password" id="password" name="password"  required>

            </fieldset>

           
              <input type="submit" class="boton boton-verde btn-enviar" value="Iniciar Sesión">
           

        </form>

    </main>

<?php 
incluirTemplate('footer');
?>