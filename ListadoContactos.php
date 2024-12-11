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
    <button onclick="document.getElementById('dialogoCrear').showModal()">Crear Contacto</button>

    <!-- Creamos el diálogo -->
    <dialog id="dialogoCrear">
            <h3>Crear Nuevo Contacto</h3>
            <form method="post" action="" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>

                <label for="avatar">Foto (Avatar):</label>
                <input type="file" name="avatar" accept="image/*" id="avatar" required>

                <button type="submit">Crear Contacto</button>
                <button type="button" onclick="document.getElementById('dialogoCrear').close()">Cancelar</button>
            </form>
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $telefono = $_POST['telefono'];
            $foto = $_FILES['avatar'];
    
            if (isset($_SESSION['usuario'])) {
                $idUsuario = $_SESSION['usuario']->getId();
               
    
                // Procesar la foto
                $nombreArchivo = $foto['name'];
                $rutaCarpeta = "img";
                $rutaFoto = "$rutaCarpeta/$nombreArchivo";
    
                if (move_uploaded_file($foto['tmp_name'], $rutaFoto)) {
                    // Guardar el contacto
                    $crear = guardarContacto($nombre, $apellidos, $telefono, $rutaFoto, $idUsuario);
                    if ($crear) {
                        echo "<div class='success'>¡Enhorabuena! Contacto creado con éxito.</div>";
                    } else {
                        echo "<div class='error'>Algo ha ido mal al crear el contacto.</div>";
                    }
                } else {
                    echo "<div class='error'>Error al subir la foto.</div>";
                }
            } else {
                echo "<div class='error'>Error: No se ha encontrado el ID del usuario.</div>";
            }
        }
    }
    ?>
</body>

</html