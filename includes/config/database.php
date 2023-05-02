<?php 

function conectarDB() : mysqli {
    $db = mysqli_connect('192.168.1.71', 'samsung', '', 'bienesraices_crud');

    if(!$db) {
        echo "No se puedo conectar";
        exit;
    }

    return  $db;
}