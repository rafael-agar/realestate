<?php

session_start();

//xcerrando session, antes:
// session_destroy

//reiniciar el aareglo de session auno vacio
$_SESSION = [];

header('Location: /');
 