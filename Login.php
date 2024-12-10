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
    <h1>Formulario de Login</h1>
</header>

<body>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once("UsuariosServices.php");
        $telefono = $_POST['telefono'];
        $contraseña = $_POST['password'];

        $usuario = iniciarSesion($telefono, $contraseña);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            echo "<p id='success'>Bienvenido " . $usuario->getTelefono() . "</p>";
            header("Location: ListadoContactos.php");
            exit();
        } else {
            echo "<p id='error'>Telefono o contraseña incorrectas</p>";
        }
    }

    ?>
    <form action="" method="post">
        <div>
            <label for="telefono">Teléfono</label>
            <input type="tel" name="telefono" id="telefono" required>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <input type="submit" value="Iniciar Sesión">
        <a href="Registro.php">Registrarse</a>
    </form>

    <footer>
        <p>© 2024 Agenda de Contactos. Todos los derechos reservados.</p>
    </footer>
</body>

</html>