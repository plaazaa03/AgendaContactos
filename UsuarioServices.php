<?php 
session_start();
require_once "Usuario.php";

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

function iniciarSesion($telefono, $contraseña) {

    $conexion = conectarBD();

    $sql = "SELECT * FROM Usuario WHERE telefono = ? AND contraseña = ?";
    $queryFormateada = $conexion -> prepare($sql);
    $queryFormateada -> bind_param("is", $telefono , $contraseña);
    $seHaEjecutadoLaQuery = $queryFormateada -> execute();
    $resultado = $queryFormateada -> get_result();

    if ($seHaEjecutadoLaQuery && $resultado -> num_rows == 1) {
        $usuarioBD = $resultado -> fetch_assoc();
        $usuario = new Usuario($usuarioBD['id'], $usuarioBD['telefono'], $usuarioBD['contraseña'], $usuarioBD['avatar']);
        $conexion -> close();
        return $usuario;
    } else {
        return false;
    }
}

function guardarContacto($telefono, $contraseña, $carpetaDestino) {
    $conexion = conectarBD();

    $sql = "INSERT INTO Usuario (telefono, contraseña, foto) VALUES (?, ?, ?)";
    $queryFormateada = $conexion -> prepare($sql);
    $queryFormateada -> bind_param("iss", $telefono, $contraseña, $carpetaDestino);
    $seHaEjecutadoLaQuery = $queryFormateada -> execute();
    $conexion -> close();

    if ($seHaEjecutadoLaQuery) {
        return true;
    } else {
        return false;
    }
}




?>