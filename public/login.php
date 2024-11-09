<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login.css">
    <title>Residencial</title>
</head>

<body>
    <header>
        <h2 class="logo">Residencial San Francisco</h2>
        <nav class="navigation">
            <a href="#" onclick = "window.location.href='../Inicio/inicio.html'">Inicio</a>
            <a href="#" onclick = "window.location.href='../Contact/contact.html'">Contacto</a>
            <button class="btnLogin-pop">Login</button>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>

        <div class="form-box login">
            <h2>Login</h2>
            <form id="login">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" required  name="email">
                    <label>Correo</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" required name="pass">
                    <label>Contraseña</label>
                </div>
                <div class="remember">
                    <label><input type="checkbox">
                        Remember me</label>
                </div>
                <button type="submit" class="btn">
                    Login
                </button>
                <div class="login-register">
                    <p>No tienes cuenta?<a href="#" class="register-link"> Registrate ya</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registrate</h2>
            <form action="#">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" required>
                    <label>Usuario</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" required>
                    <label>Correo</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" required>
                    <label>Contraseña</label>
                </div>
                <div class="remember">
                    <label><input type="checkbox" required>
                        Aceptar Terminos y Condiciones</label>
                </div>
                <button type="submit" class="btn">
                    Registrar
                </button>
                <div class="login-register">
                    <p>Ya tienes cuenta?<a href="#" class="login-link"> Inicia Sesion</a></p>
                </div>
            </form>
        </div>

    </div>


    <script src="scripts/login.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>