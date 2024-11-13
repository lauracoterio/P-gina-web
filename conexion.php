<?php
$host = "localhost"; //Con ingreso a mi Base de Datos (SERVIDOR MYSQL)
$bd_name = "bd_usuarios"; //Base de Datos a la que voy a conectar
$username = "root"; //Siempre va a ser root (USUARIO DE MYSQL)
$password = ""; //Contraseña, en este caso está vacía

//Conectarse a la Base de Datos en MySQL
$conexion = new mysqli($host, $username, $password, $bd_name);

//Verificar la conexión
if ($conexion->connect_error) {
    die("Error de Conexión: " . $conexion->connect_error);
}
?>
