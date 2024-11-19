<?php 
session_start();
require_once "Contacto.php";

function conectarBD() {
    //crear variables con la informacion para la conexion
    $host = "localhost";
    $bd = "AgendaContactos";
    $username = "root";
    $password = "";

    //crear la conexion mediante mysqli
    $conexion = new mysqli($host, $username, $password, $bd);

    //comprobar si se realiza la conexion mediante mysqli
    if (!$conexion->connect_error) {
        return $conexion;
    } else {
        die("Error al conectar: " . $conexion->connect_error);
    }
}


?>