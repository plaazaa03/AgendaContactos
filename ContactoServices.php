<?php
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


function guardarContacto($telefono, $nombre, $apellidos, $foto, $idUsuario)
{
    $conexion = conectarBD();
    $sql = "INSERT INTO contactos (nombre, apellidos, telefono, foto, idUsuario) VALUES (?, ?, ?, ?, ?)";
    $queryFormateada = $conexion->prepare($sql);
    $queryFormateada->bind_param('ssisi',  $nombre, $apellidos, $telefono, $foto, $idUsuario);
    $todoBien = $queryFormateada->execute();
    $conexion->close();
    return $todoBien;
}

function obtenerContactosPorBusqueda($buscar) {
    $conexion = conectarBD();
    $sql = "SELECT * FROM Contactos WHERE telefono LIKE ? OR nombre LIKE ? OR apellidos LIKE ?";
    $queryFormateado = $conexion->prepare($sql);
    $queryFormateado->bind_param("sss", $buscar, $buscar, $buscar);
    $seHaEjecutadoLaQuery = $queryFormateado->execute();
    
    if ($seHaEjecutadoLaQuery) {
        $resultado = $queryFormateado->get_result();
        $contactos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $contactos[] = $fila;
        }
        return $contactos;
    } else {
        return array();
    }
}

function obtenerContactos() {
    $conexion = conectarBD();
    $sql = "SELECT * FROM Contactos WHERE idUsuario = ?";
    $queryFormateado = $conexion->prepare($sql);
    $seHaEjecutadoLaQuery = $queryFormateado -> execute();
    $resultado = $queryFormateado -> get_result();

    if ($seHaEjecutadoLaQuery && $resultado -> num_rows == 1) {
        return true;
    } else {
        return false;
    }
    
}

?>