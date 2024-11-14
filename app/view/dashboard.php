<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../public/login.php');
} else {
    if ($_SESSION['user']["rol"] != "admin" && $_SESSION['user']["rol"] != "s_admin") {
        header('Location: inicio.php');
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residencial</title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>

<body>
    <header>
        <h2 class="logo">Residencial San Francisco</h2>
        <nav class="navigation">
            <a href="#" onclick="window.location.href='inicio.php'">Inicio</a>
            <?php
            if ($_SESSION["user"]["rol"] === "s_admin") {
                echo '<a href="#" onclick="showSection(\'user-section\')">Usuarios</a>';
            }
            ?>
            <a href="#" onclick="window.location.href='contact.php'">Contacto</a>
            <a href="#" onclick="showSection('request-section')" class="active">Solicitudes</a>
            <a href="#" onclick="window.location.href='http://localhost/residencial/?action=logout'">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="wrapper">
        <!-- Sección de Solicitudes -->
        <div class="form-box contact" id="request-section">
            <h2>Solicitudes</h2>

            <div class="search-box">
                <input
                    type="text"
                    id="contactSearch"
                    placeholder="Buscar por usuario..."
                    nkeyup="filterContacts()">
            </div>

            <div class="card-container">
                
            </div>
        </div>

        <!-- Sección de Usuarios -->
        <div class="form-box users" id="user-section" style="display: none;">
            <h2>Lista de Usuarios</h2>

            <div class="search-box">
                <input
                    type="text"
                    id="userSearch"
                    placeholder="Buscar por username..."
                    onkeyup="filterUsers()">
            </div>

            <ul class="user-list"></ul>
        </div>
    </div>
    <script src="scripts/dashboard.js"></script>
</body>

</html>