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
    <link rel="stylesheet" href="styles/contact.css">
</head>

<body>
    <header>
        <h2 class="logo">Residencial San Francisco</h2>
        <nav class="navigation">
            <a href="#" onclick="window.location.href='inicio.php'">Inicio</a>
            <?php
            if ($_SESSION["user"]["rol"] == "s_admin" || $_SESSION["user"]["rol"] == "admin") {
                echo '<a href="dashboard.php">Dashboard</a>';
            }
            ?>
            <a href="#" class="contact">Contacto</a>
            <a href="#" class="perfil" onclick="window.location.href='editProfile.php'">Perfil</a>
            <a href="#" onclick="window.location.href='<?php echo $_ENV['DOMAIN']; ?>/residencial/?action=logout'">Cerrar Sesión</a> <?php#EDITED?>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>

        <div class="form-box contact">
            <h2>Contacto</h2>
            <form id="contact">
                <div class="form-columns">
                    <div class="input-box">
                        <input type="hidden" name="iduser" value="<?php echo $_SESSION['user']['id'] ?>" required>
                        <input type="text" name="name" required>
                        <label>Nombre Completo</label>
                    </div>
                    <div class="input-box">
                        <input type="date" name="birth" required>
                        <label>Fecha de Nacimiento</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="dui" required>
                        <label>DUI</label>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" required>
                        <label>Correo Electrónico</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="phone" required>
                        <label>Número de Teléfono</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="address" required>
                        <label>Dirección Actual</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="occupation" required>
                        <label>Ocupación</label>
                    </div>
                    <div class="input-box">
                        <input type="number" name="income" required>
                        <label>Ingreso Mensual Aproximado</label>
                    </div>
                    <div class="input-box">
                        <input type="number" name="family_members" required>
                        <label>Número de Personas en el Hogar</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="reason_interest" required>
                        <label>Motivo de Interés en la Residencial</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="personal_reference" required>
                        <label>Referencias Personales (Nombre, Teléfono, Relación)</label>
                    </div>
                    <div class="input-box">
                        <input type="date" name="application_date" required>
                        <label>Fecha de Aplicación</label>
                    </div>
                </div>
                <div class="remember">
                    <label><input type="checkbox" required> Autorización para Comprobación de Datos</label>
                </div>
                <button type="submit" class="btn">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    <script src="scripts/contact.js"></script>
</body>

</html>