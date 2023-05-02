<?php 

    require '../../includes/config/database.php';
    $db = conectarDB();

    //consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //arreglo con mensajes de errores
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';
    $creado = date('Y/m/d');

    //ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //filtros de validadcion y saniamiento
        // $numero = "1HOLA";
        // $numero2 = 1;

        // $resultado = filter_var($numero, FILTER_SANITIZE_NUMBER_INT);
        // $resultado = filter_var($numero, FILTER_VALIDATE_EMAIL;

        // var_dump($resultado);

        // exit;
        // mysqli_real_escaoe_string()

            //         echo "<pre>";
            // var_dump($_POST);
            // echo "<pre>";

        $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
        $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
        $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor'] );

        if(!$titulo) {
            $errores[] = "Debes añadir un título";
        }

        if(!$precio) {
            $errores[] = "El precio es obligatorio";
        }

        if(strlen($descripcion) < 50) {
            $errores[] = "La descripción es obligatoria y al menos 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "Numero de habitaciones";
        }

        if(!$wc) {
            $errores[] = "El numero de banos";
        }

        if(!$estacionamiento) {
            $errores[] = "Estacionamiento";
        }

        if(!$vendedorId) {
            $errores[] = "Elige un vendedor";
        }


        // echo "<pre>";
        // var_dump($errores);
        // echo "<pre>";

        //revisar que el array de errores este vacio
        if(empty($errores)){
             // /insertar en la base de datos
            $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) 
            VALUES ( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId' )";

            // echo $query;

            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                //redirecionar al usuario
                //function header para redireccionar a un usuario o cambiar direccion usuario
                header('Location: /admin');
            }
        }

    }
    
    require '../../includes/funciones.php';
    incluirTemplate('header'); 
?>

<main class='contenedor seccion'>
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>   
    <?php endforeach ?>

    <!-- enctype="multipart/form-data" habilitarlo para file, usando la global $_FILES -->
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" placeholder="Titulo propiedad" name="titulo" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" placeholder="Precio propiedad" name="precio" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen" name="imagen">

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>
        
        <fieldset>
            <legend>Información propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ejemplo: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ejemplo: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ejemplo: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="">--Selecione un vendedor--</option>
                <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                    <option
                    <?php echo $vendedorId === $row['id'] ? 'selected' : ''; ?>
                    value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre'] . " " . $row['apellido']; ?> 
                    </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" class="boton boton-verde" value="Crear Propiedad">

    </form>

</main>

<?php incluirTemplate('footer'); ?>
