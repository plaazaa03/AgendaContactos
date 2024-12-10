<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Lista de Contactos</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='contactos.css'>
</head>

<?php
require_once("ContactoServices.php");
require_once("Contacto.php");
require_once("Usuario.php");
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit();
}
?>

<body>
    <header>
        <div id="img-ico">
            <img src="img/icono.png" alt="">
        </div>
        <h1>Lista de Contactos</h1>
    </header>
    <form action="" method="GET">
        <input type="text" name="buscar" placeholder="Buscar contacto">
        <button type="submit">Buscar</button>
    </form>
    <!-- Creamos el botón para abrir el diálogo -->
    <button onclick="document.getElementById('dialog-crear-contacto').showModal()">Crear Contacto</button>

    <!-- Creamos el diálogo -->
    <dialog id="dialog-crear-contacto">
        <h2>Rellena los campos para crear un nuevo contacto</h2>
        <form id="form-crear" action="" method="post" enctype="multipart/form-data">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" required>
            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono" required>
            <label for="foto">Foto:</label>
            <input type="file" name="foto" accept="image/*" id="foto" required>
           
            <button id="crear-button" type="button">Crear Contacto</button>
        </form>
        <button id="cerrar-button"
            onclick="document.getElementById('dialog-crear-contacto').close()">Cerrar</button>
    </dialog>

    <ul id="lista-contactos">
        <?php
        // Obtener los contactos de la base de datos
        require_once("ContactoServices.php");
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $buscar = $_GET['buscar'];
            $contactos = obtenerContactosPorBusqueda($buscar);
        } else {
            $contactos = obtenerContactos();
        }

        // Mostrar los contactos
        if (count($contactos) > 0) {
            foreach ($contactos as $contacto) {
                echo "<li>";
                echo "<h3>" . $contacto['nombre'] . " " . $contacto['apellidos'] . "</h3>";
                echo "<p>Telefono: " . $contacto['telefono'] . "</p>";
                if ($contacto['foto'] != '') {
                    echo "<img src='" . $contacto['foto'] . "' alt='Foto'>";
                }
                echo "</li>";
            }
        } else {
            echo "<p>No hay contactos.</p>";
        }
        ?>
    </ul>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once("ContactosServices.php");
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $foto = $_FILES['foto'];
        $id_usuario = $_POST['id_usuario'];

        // Verificar si el teléfono ya existe
        if (telefonoExistente($telefono)) {
            echo "<p id='error'>El teléfono ya existe</p>";
        } else {
            // Recuperar el nombre del archivo
            $nombreArchivo = $foto['name'];

            // Recuperar el temporal
            $fotoTmp = $foto['tmp_name'];

            // Ruta foto
            $carpetaDestino = "img/$nombreArchivo";

            if (file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            // Mover el archivo
            move_uploaded_file($fotoTmp, $carpetaDestino);

            if (guardarContacto($telefono, $nombre, $apellidos, $carpetaDestino, $id_usuario)) {
                echo "<p id='success'>Contacto creado con éxito</p>";
                header("Location: ListaContactos.php");
                exit();
            } else {
                echo "<p id='error'>No se ha podido crear el contacto</p>";
            }
        }
    }
    ?>
</body>

</html