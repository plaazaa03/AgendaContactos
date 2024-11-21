<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='contactos.css'>
    <script src='main.js'></script>
</head>
<header>
    <div id="img-ico">
        <img src="img/icono.png" alt="">
    </div>
    <h1>Formulario de Registro</h1>
</header>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('UsuariosServices.php');
        $telefono = $_POST['telefono'];
        $contraseña = $_POST['password'];
        $avatar = $_POST['avatar'];

        // Recuperar el nombre del archivo
        $nombreArchivo = $avatar['name'];

        // Recuperar el temporal
        $avatarTmp = $avatar['tmp_name'];

        // Ruta avatar
        $carpetaDestino = "img/$nombreArchivo";

        if (file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        // Mover el archivo
        move_uploaded_file($avatarTmp, $nombreArchivo);

        if (guardarContacto($telefono, $contraseña, $carpetaDestino)) {
            echo "Contacto guardado con exito";
            header("Location: Login.php");
        } else {
            echo "<p id='error'>No se ha podido registrar el contacto</p>";
        }

    }

    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="telefono">Teléfono</label>
            <input type="tel" name="telefono" id="telefono" required>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
        <label for="avatar">Avatar:</label>
        <input type="file" name="avatar" accept="image/*" id="avatar" required>
        </div>
        <input type="submit" value="Crear Contacto">
        <a href="Login.php">Volver al Login</a>
    </form>

    <footer>
        <p>© 2024 Agenda de Contactos. Todos los derechos reservados.</p>
    </footer>

</body>

</html>