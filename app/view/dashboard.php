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
            <?php 
            if($_SESSION["user"]["rol"]==="s_admin"){
                echo '<a href="#" onclick="showSection(\'user-section\')">Usuarios</a>';
            }
            ?>
            <a href="#" onclick="showSection('request-section')" class="active">Solicitudes</a>
            <a href="#" onclick="window.location.href='http://localhost/residencial/?action=logout'">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="wrapper">
        <!-- Sección de Solicitudes -->
        <div class="form-box contact" id="request-section">
            <h2>Solicitudes</h2>
            <div class="card-container">
                <div class="card" onclick="openCardDetails('Juan Pérez', '01234567-8', 'juan.perez@example.com', '7890-1234', 'Calle Falsa 123', 'Ingeniero', '1200', '4', 'Seguridad y tranquilidad', 'Ana López, 7654-3210, Amiga', '2024-11-01')">
                    <p><strong>Nombre:</strong> Juan Pérez</p>
                    <p><strong>DUI:</strong> 01234567-8</p>
                    <p><strong>Email:</strong> juan.perez@example.com</p>
                </div>
                <div class="card" onclick="openCardDetails('María García', '98765432-1', 'maria.garcia@example.com', '6543-2109', 'Av. Principal 456', 'Contadora', '1500', '3', 'Cercanía al trabajo', 'Carlos Rivas, 6789-0123, Hermano', '2024-11-02')">
                    <p><strong>Nombre:</strong> María García</p>
                    <p><strong>DUI:</strong> 98765432-1</p>
                    <p><strong>Email:</strong> maria.garcia@example.com</p>
                </div>
                
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
                    onkeyup="filterUsers()"
                >
            </div>
            
            <ul class="user-list"></ul>
        </div>
    </div>
    <script src="scripts/dashboard.js"></script>
</body>

</html>

