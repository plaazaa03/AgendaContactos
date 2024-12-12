<?php
require_once 'Mensajes.php';
require_once 'ContactoServices.php';
require_once 'Usuario.php';
require_once 'Contacto.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: Login.php');
    exit;
}

$idUsuario = $_SESSION['usuario']->getId();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "<div class='error'>Error: No se ha proporcionado el ID del contacto.</div>";
    exit;
}

$contactos = obtenerContactos($idUsuario);

$contacto = null;
foreach ($contactos as $c) {
    if ($c->getId() == $id) {
        $contacto = $c;
        break;
    }
}

if (!$contacto) {
    echo "<div class='error'>Error: No se ha encontrado el contacto.</div>";
    exit;
}

// Procesar el envío del mensaje
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['mensaje'])) {
        $mensaje = $_POST['mensaje'];
        $fechaEnvio = date('Y-m-d H:i:s');

        $guardar = guardarMensaje($mensaje, $fechaEnvio, $contacto->getId());
    }
}

// Obtener todos los mensajes del contacto
$mensajes = obtenerMensajes($contacto->getId());

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de <?php echo $contacto->getNombre(); ?></title>
    <link rel="stylesheet" href="contactos.css">
</head>
<body>
    <header>
    <div id="img-ico">
        <img src="img/icono.png" alt="">
    </div>
        <h1>Conversación con <?php echo $contacto->getNombre(); ?></h1>
    </header>
    <main>
        <section class="detalles-contacto">
            <div class="avatar-info">
                <img src="<?php echo $contacto->getFoto(); ?>" class="foto-contacto" alt="Avatar de <?php echo $contacto->getNombre(); ?>">
                <div class="info-contacto">
                    <h2><?php echo $contacto->getNombre(); ?></h2>
                    <p>Teléfono: <?php echo $contacto->getTelefono(); ?></p>
                </div>
            </div>
        </section>

        <section class="conversacion">
            <div class="mensajes">
                <?php if (!empty($mensajes)): ?>
                    <?php foreach ($mensajes as $mensaje): ?>
                        <div class="mensaje">
                            <p><?php echo $mensaje->getTexto(); ?></p>
                            <small><?php echo $mensaje->getFechaEnvio(); ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay mensajes en esta conversación.</p>
                <?php endif; ?>
            </div>

            <div class="enviar-mensaje">
                <form method="post" action="">
                    <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." rows="4" required></textarea>
                    <button type="submit">Enviar mensaje</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
