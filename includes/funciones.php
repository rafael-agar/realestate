<?php 

require 'app.php';

function incluirTemplate (string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/{$nombre}.php"; 
}

function estaAutenticado() : bool {
    session_start();

    //en file login.php "$_SESSION['login']" es igual a "true"
    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
    return false;
}