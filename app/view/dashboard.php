<?php
session_start();  
if(!isset($_SESSION['user'])) {  
    header('Location: ../../public/login.php'); 
}
$user = $_SESSION["user"];
echo "Login exitoso bienvenido usuario: {$user["username"]}";
?>