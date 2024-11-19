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
    <form action="" method="post">
        <div>
        <label for="telefono">Teléfono</label>
        <input type="tel" name="telefono" id="telefono" required>
        </div>
        <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>
        </div>
        <div>
        <label for="avatar">Avatar</label>
        <input type="file" name="avatar" id="avatar" accept="image/*" required>
        </div>
        <input type="submit" value="Crear Contacto">
        <a href="Login.php">Volver al Login</a>
    </form>

    <footer>
        <p>© 2024 Agenda de Contactos. Todos los derechos reservados.</p>
    </footer>

</body>

</html>