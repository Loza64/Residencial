<?php 


session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../public/login.php');
}

/*session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../public/login.php');
} else {
    if ($_SESSION['user']["rol"] != "admin" && $_SESSION['user']["rol"] != "s_admin") {
       header('Location: inicio.php');
    }
}*/
?> 

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residencial</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <script>
        function openCardDetails(name, dui, email, phone, address, occupation, income, familyMembers, interest, reference, applicationDate) {
            const detailsWindow = window.open("", "_blank", "width=400,height=600");
            detailsWindow.document.write(`
                <html>
                    <head>
                        <title>Detalles de la Solicitud</title>
                        <style>
                            body { font-family: 'Poppins', sans-serif; 
                                    padding: 20px; 
                                    line-height: 1.6; 
                                    background-color: #2c3e50; 
                                    color: #FFFFFF;  
                                }
                            h2 { color: #FFFFFF; }
                            p { margin: 10px 0; }
                        </style>
                    </head>
                    <body>
                        <h2>Detalles de la Solicitud</h2>
                        <p><strong>Nombre:</strong> ${name}</p>
                        <p><strong>DUI:</strong> ${dui}</p>
                        <p><strong>Email:</strong> ${email}</p>
                        <p><strong>Teléfono:</strong> ${phone}</p>
                        <p><strong>Dirección:</strong> ${address}</p>
                        <p><strong>Ocupación:</strong> ${occupation}</p>
                        <p><strong>Ingreso Mensual:</strong> $${income}</p>
                        <p><strong>Miembros del Hogar:</strong> ${familyMembers}</p>
                        <p><strong>Motivo de Interés:</strong> ${interest}</p>
                        <p><strong>Referencias:</strong> ${reference}</p>
                        <p><strong>Fecha de Aplicación:</strong> ${applicationDate}</p>
                    </body>
                </html>
            `);
            detailsWindow.document.close();
        }

        function showSection(sectionId) {
            
            document.getElementById('user-section').style.display = sectionId === 'user-section' ? 'block' : 'none';
            document.getElementById('request-section').style.display = sectionId === 'request-section' ? 'block' : 'none';
            
            
            document.querySelector('.navigation a[onclick*="user-section"]').classList.toggle('active', sectionId === 'user-section');
            document.querySelector('.navigation a[onclick*="request-section"]').classList.toggle('active', sectionId === 'request-section');
        }

        function deleteUser(userId) {
            if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
                alert("Usuario con ID " + userId + " eliminado.");
                // Acá iría el AJAX para eliminar de la base de datos
            }
        }
    </script>
</head>

<body>
    <header>
        <h2 class="logo">Residencial San Francisco</h2>
        <nav class="navigation">
            <a href="#" onclick="showSection('user-section')">Usuarios</a>
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
            <ul class="user-list">
                <li>
                    <span>Username: user1 | Rol: admin</span>
                    <button onclick="deleteUser(1)">Eliminar</button>
                </li>
                <li>
                    <span>Username: user2 | Rol: editor</span>
                    <button onclick="deleteUser(2)">Eliminar</button>
                </li>
                <li>
                    <span>Username: user3 | Rol: viewer</span>
                    <button onclick="deleteUser(3)">Eliminar</button>
                </li>
            
            </ul>
        </div>
    </div>
</body>

</html>

