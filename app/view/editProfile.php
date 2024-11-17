<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../../public/login.php');
} else {
  if ($_SESSION['user']["rol"] == "admin" || $_SESSION['user']["rol"] == "s_admin") {
    header('Location: dashboard.php');
  }
}
#To use .env variables
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residencial</title>
    <link rel="stylesheet" href="styles/editProfile.css">
</head>

<body>
    <header>
        <h2 class="logo">Residencial San Francisco</h2>
        <nav class="navigation">
            <a href="#" onclick="window.location.href='inicio.php'">Inicio</a>
            <?php if ($_SESSION["user"]["rol"] == "s_admin" || $_SESSION["user"]["rol"] == "admin") { ?>
                <a href="dashboard.php">Dashboard</a>
            <?php } ?>
            <a href="#" onclick="window.location.href='contact.php'">Contacto</a>
            <a href="#" class="perfil">Perfil</a>
            <a href="#" onclick="window.location.href='<?php echo $_ENV['DOMAIN']; ?>/residencial/?action=logout'">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="wrapper">
        <div class="form-box perfil">
            <h2>Editar Perfil</h2>
            <form id="perfil">
                <div class="form-columns">
                    <div class="input-box">
                        <input type="hidden" name="iduser" value="<?php echo $_SESSION['user']['id']; ?>" required>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['user']['username']); ?>" readonly required>
                        <label>Usuario</label>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" readonly required>
                        <label>Correo</label>
                    </div>
                    <div id="edit-buttons">
                        <button type="button" class="btn" onclick="enableEditing()">Editar</button>
                        <button type="submit" class="btn" style="display: none;">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="scripts/editProfile.js"></script>
</body>

</html>
