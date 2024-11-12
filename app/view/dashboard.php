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
    <link rel="stylesheet" href="styles/contact.css">
</head>

<body>
    <header>
        <h2 class="logo">Residencial San Francisco</h2>
        <nav class="navigation">
            <a href="#" >Usuarios</a>
            <a href="#" class="soli">Solicitudes</a>
            <a href="#" onclick="window.location.href='http://localhost/residencial/?action=logout'">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="wrapper">

        <div class="form-box contact">
            <h2>Solicitudes</h2>
            
        </div>
        


    </div>



</body>

</html>