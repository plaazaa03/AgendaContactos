<?php
require_once 'Contacto.php';
require_once 'Mensajes.php';

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

function guardarContacto( $nombre, $apellidos, $telefono, $foto, $idUsuario) {
    $conexion = conectarBD();
    $sql = "INSERT INTO Contactos (nombre, apellidos, telefono, foto, idUsuario) VALUES (?, ?, ?, ?, ?)";
    $queryFormateada = $conexion->prepare($sql);
    $queryFormateada->bind_param('ssisi',  $nombre, $apellidos, $telefono, $foto, $idUsuario);
    $todoBien = $queryFormateada->execute();
    $conexion->close();
    return $todoBien;
}
function obtenerContactos($idUsuario) {
    $conexion = conectarBD();
    $sql = "SELECT * FROM Contactos WHERE idUsuario = ?";
    $queryFormateada = $conexion->prepare($sql);
    $queryFormateada->bind_param('i', $idUsuario);
    $queryFormateada->execute();
    $resultado = $queryFormateada->get_result();
    $contactos = [];

    while ($fila = $resultado->fetch_assoc()) {
        $contactos[] = new Contacto(
            $fila['id'],
            $fila['nombre'],
            $fila['apellidos'],
            $fila['telefono'],
            $fila['foto'],
            $fila['idUsuario']
        );
    }

    $queryFormateada->close();
    $conexion->close();
    return $contactos;
}
function guardarMensaje($texto, $fechaEnvio, $idContacto) {
    $conexion = conectarBD();
    $sql = "INSERT INTO mensajes (texto, fecha_envio, id_contacto) VALUES (?, ?, ?)";
    $queryFormateada = $conexion->prepare($sql);
    $queryFormateada->bind_param('ssi', $texto, $fechaEnvio, $idContacto);
    $queryFormateada->execute();
    $queryFormateada->close();
    $conexion->close();
    return true;
}

function obtenerMensajes($idContacto) {
    $conexion = conexionBD();
    $sql = "SELECT * FROM mensajes WHERE id_contacto = ?";
    $queryFormateada = $conexion->prepare($sql);
    $queryFormateada->bind_param('i', $idContacto);
    $queryFormateada->execute();
    $resultado = $queryFormateada->get_result();
    $mensajes = [];

    while ($fila = $resultado->fetch_assoc()) {
        $mensaje = new Mensaje();
        $mensaje->setId($fila['id']);
        $mensaje->setTexto($fila['texto']);
        $mensaje->setFechaEnvio($fila['fecha_envio']);
        $mensajes[] = $mensaje;
    }

    $queryFormateada->close();
    $conexion->close();
    return $mensajes;
}
function enviarMensaje($idContacto, $mensaje) {
    $conexion = conexionBD();
    $sql = "INSERT INTO mensajes (texto, fecha_envio, id_contacto) VALUES (?, ?, ?)";
    $queryFormateada = $conexion->prepare($sql);
    $fechaEnvio = date('Y-m-d H:i:s');
    $queryFormateada->bind_param('ssi', $mensaje, $fechaEnvio, $idContacto);
    $queryFormateada->execute();
    $queryFormateada->close();
    $conexion->close();
    return true;
}