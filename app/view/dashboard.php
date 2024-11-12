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