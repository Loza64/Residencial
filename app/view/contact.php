<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../public/login.php');
}

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
            <a href="#" onclick = "window.location.href='inicio.php'">Inicio</a>
            <a href="#" class="contact">Contacto</a>
            <a href="#" onclick="window.location.href='http://localhost/residencial/?action=logout'">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>

        <div class="form-box contact">
            <h2>Contacto</h2>
            <form action="#">
                <div class="form-columns">
                    <div class="input-box">
                        <input type="text" required>
                        <label>Nombre Completo</label>
                    </div>
                    <div class="input-box">
                        <input type="date" required>
                        <label>Fecha de Nacimiento</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>DUI</label>
                    </div>
                    <div class="input-box">
                        <input type="email" required>
                        <label>Correo Electrónico</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>Número de Teléfono</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>Dirección Actual</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>Ocupación</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>Ingreso Mensual Aproximado</label>
                    </div>
                    <div class="input-box">
                        <input type="number" required>
                        <label>Número de Personas en el Hogar</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>Motivo de Interés en la Residencial</label>
                    </div>
                    <div class="input-box">
                        <input type="text" required>
                        <label>Referencias Personales (Nombre, Teléfono, Relación)</label>
                    </div>
                    <div class="input-box">
                        <input type="date" required>
                        <label>Fecha de Aplicación</label>
                    </div>
                </div>
                <div class="remember">
                    <label><input type="checkbox" required> Autorización para Comprobación de Datos</label>
                </div>
                <button type="submit" class="btn">Enviar</button>
            </form>
        </div>
        


    </div>



</body>

</html>