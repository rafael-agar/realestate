<?php

    require 'includes/config/database.php';
    $db = conectarDB();

    $errores = [];

    //autenticar usuario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (!$email) {
            $errores[] = "El email es obligatorio";
        }

        if (!$password) {
            $errores[] = "El password es obligatorio";
        }

        if (empty($errores)){

            //revisar si el usuario existe
            $query = "SELECT * FROM usuario WHERE email = '{$email}' ";
            $resultado = mysqli_query($db, $query);

            // var_dump($resultado);

            if ($resultado->num_rows) {
                //revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                // var_dump($usuario);

                //verificar password, esta func devuelve un booleano
                $auth = password_verify($password, $usuario['password']);  
                
                if($auth){
                    //usuario autenticado, usando super global
                    session_start();
                    //llenamo el arreglo de la session
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    // var_dump($_SESSION);

                    header ('Location: /admin');

                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El usuario no existe";
            }

        }
    }

    //header
    require 'includes/funciones.php';
    incluirTemplate('header'); 
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Passeord</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" >

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password" >

        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>
    


<?php
    incluirTemplate('footer'); 
?>