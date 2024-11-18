<?php
// Archivo index.php en public/

require_once '../app/config/settings.php';
require_once '../app/config/routes.php';

$routes = include '../app/config/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($requestUri, $routes)) {
    list($controller, $action) = explode('@', $routes[$requestUri]);
    
    $controllerFile = sprintf('../app/controller/%s.php', $controller);

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        $controllerClass = new $controller();
        if (method_exists($controllerClass, $action)) {
            echo $controllerClass->$action();
        } else {
            http_response_code(404);
            echo "Error: Acción no encontrada.";
        }
    } else {
        http_response_code(404);
        echo "Error: Controlador no encontrado.";
    }
} else {
    http_response_code(404);
    echo "Error: Ruta no encontrada.";
}
