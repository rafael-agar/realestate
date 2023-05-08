<?php 

//importar conexion
require __DIR__ . "/../config/database.php";
$db = conectarDB();

// /consultar
$query = "SELECT * FROM propiedades LIMIT {$limite}";

// /resultado
$resultado = mysqli_query($db, $query);

?>


<div class="contenedor-anuncios">
    <?php while($element = mysqli_fetch_assoc($resultado)): ?>
    <div class="anuncio">
        <picture>
            <img loading="lazy" src="/imagenes/<?php echo $element['imagen']; ?>" alt="anuncio">
        </picture>

        <div class="contenido-anuncio">
            <h3><?php echo $element['titulo']; ?></h3>
            <p><?php echo $element['descripcion']; ?></p>
            <p class="precio">$<?php echo $element['precio']; ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $element['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $element['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $element['habitaciones']; ?></p>
                </li>
            </ul>

            <a href="anuncio.php?id=<?php echo $element['id']; ?>" class="boton-amarillo-block">
                Ver Propiedad
            </a>
        </div><!--.contenido-anuncio-->
    </div><!--anuncio-->
    <?php endwhile; ?>
</div> <!--.contenedor-anuncios-->

<?php
    mysqli_close($db);
?>