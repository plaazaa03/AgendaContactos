<?php
require_once 'ContactoServices.php';
require_once 'Usuario.php';
require_once 'Contacto.php';
session_start();

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

            if (!is_dir($rutaCarpeta)) {
                mkdir($rutaCarpeta, 0777, true); // Crear la carpeta si no existe
            }


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

if (isset($_SESSION['usuario'])) {
    $idUsuario = $_SESSION['usuario']->getId();
    $contactos = obtenerContactos($idUsuario);
    $avatar = $_SESSION['usuario']->getAvatar();


    $terminoBusqueda = isset($_POST['busqueda']) ? trim($_POST['busqueda']) : '';


    if ($terminoBusqueda !== '') {
        $contactosFiltrados = [];
        foreach ($contactos as $contacto) {
            if (stripos($contacto->getNombre(), $terminoBusqueda) !== false) {
                $contactosFiltrados[] = $contacto;
            }
        }

        $contactos = $contactosFiltrados;


    }

    if(isset($_GET["logout"])) {
        session_destroy();
        header("Location: Login.php");
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mis Contactos</title>
        <link rel="stylesheet" href="contactos.css">
    </head>

    <body>
        <header>
            <div id="img-ico">
                <img src="img/icono.png" alt="">
            </div>
            <h1>Mis Contactos<div class="avatar"><img src="<?php echo $avatar; ?>" alt="Avatar"></div></h1>
            <a class="cerrar-sesion" href="?logout">Cerrar Sesión</a>
        </header>
        <main>
            <section class="busqueda">
                <form method="POST" action="">
                    <input type="text" name="busqueda" placeholder="Buscar por nombre"
                        value="<?php echo $terminoBusqueda; ?>">
                    <button type="submit">Buscar</button>
                </form>
                <div class="centro">
                    <button class="btn-crear-contacto" onclick="document.getElementById('dialogoCrear').showModal()">Crear
                        Nuevo Contacto</button>
                </div>
            </section>

            <article class="lista-contactos">
                <?php if (empty($contactos)): ?>
                    <p>No tienes contactos guardados.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($contactos as $contacto): ?>
                            <li class="contacto-card">
                                <img src="<?php echo $contacto->getFoto(); ?>" class="foto-contacto"
                                    alt="Foto de <?php echo $contacto->getNombre(); ?>">
                                <div class="info-contacto">
                                    <h2><?php echo $contacto->getNombre();?> <?php echo $contacto->getApellidos(); ?></h2>
                                    <p>Teléfono: <?php echo $contacto->getTelefono(); ?></p>
                                    <a class="ver-detalle" href="detalles.php?id=<?php echo $contacto->getId(); ?>">Detalles</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </article>

            <dialog id="dialogoCrear" class="dialogo-crear">
                <h3 class="dialogo-titulo">Crear Nuevo Contacto</h3>
                <form method="post" action="" enctype="multipart/form-data" class="dialogo-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required>

                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required>

                    <label for="avatar">Foto (Avatar):</label>
                    <input type="file" name="avatar" accept="image/*" id="avatar" required>

                    <div class="form-buttons">
                        <button type="submit" class="btn-crear">Crear</button>
                        <button type="button" class="btn-cancelar"
                            onclick="document.getElementById('dialogoCrear').close()">Cancelar</button>
                    </div>
                </form>
            </dialog>

        </main>
    </body>

    </html>


    <?php
} else {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header('Location: Login.php');
    exit();
}
?>