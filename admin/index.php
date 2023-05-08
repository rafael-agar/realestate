<?php

require '../includes/funciones.php';
$auth = estaAutenticado();

if(!$auth){
    header('Location: /');
}
    
    // echo "<pre>";
    // var_dump($_GET);
    // echo "</pre>";

     // /incluye un template

    incluirTemplate('header'); 

    //importar la coneccion
    require '../includes/config/database.php';
    $db = conectarDB();

    //escribir el query
    $query = "SELECT * FROM propiedades";

    //la consulta DB
    $resultadoConsulta = mysqli_query($db, $query);

    // ?? placeholder, si no exite? le asigna X
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        //normalizamos
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            //eliminar el archivo DE IMAGEN
            $query = "SELECT imagen FROM propiedades WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink('../imagenes/' .$propiedad['imagen']);
            //elimina la propiedad
            $query = "DELETE FROM propiedades WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                header('location: /admin?resultado=3');
            }
        }
    }

   
?>

<main class='contenedor seccion'>
    <h1>Administrador de Bienes Raices</h1>

    <!-- //resultado es enviado desde crear.php 
    // el viene como intero, o tambien se puede usar intval( intval($resultado) === 1)
    -->
    <?php if ( intval($resultado) === 1): ?> 
        <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php elseif ( intval($resultado) === 2): ?>
        <p class="alerta exito">Anuncio Actializado Correctamente</p>
        <?php elseif ( intval($resultado) === 3): ?>
        <p class="alerta exito">Anuncio Eliminado Correctamente</p>   
    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr class="tr-text">
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody> <!-- Mostrar los resultado de la BD -->
            <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
            <tr class="tr-text">
                <td><?php echo $propiedad['id']; ?></td>
                <td><?php echo $propiedad['titulo']; ?></td>
                <td><img class="imagen-tabla" src="../imagenes/<?php echo $propiedad['imagen']; ?>" /></td>
                <td>$<?php echo $propiedad['precio']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?> ">
                        <input type="submit" class="boto-rojo-block" value="Eliminar">
                    </form>
                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boto-verde-block">Actualizar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
    
</main>

<?php 

//cerrar conexion BD
mysqli_close($db);

incluirTemplate('footer'); ?>
