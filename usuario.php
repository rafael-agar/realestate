<?php 

//importar conexion
require "includes/config/database.php";
$db = conectarDB();

// crar el email
$email = "agargato@correo.com";
$password = "123456";
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//query
$query = " INSERT INTO usuario (email, password) VALUES ('{$email}', '{$passwordHash}'); ";



echo $passwordHash;

mysqli_query($db, $query);

