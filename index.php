<?php  
require_once 'app/controller/controller.php';  
require_once 'app/config/settings.php';  
require_once 'app/request.php';  

// Configuración inicial  
$config = new Settings();  
if ($config->getMode() == "DEVELOPMENT") {  
    ini_set('display_errors', 1);  
    ini_set('display_startup_errors', 1);  
    error_reporting(E_ALL);  
}  

// Redirección inicial  
if (strcmp($_SERVER['REQUEST_URI'], '/residencial/') === 0) {  
    header("Location: /residencial/public/login.php");  
    exit();  
}  

// Configuración de cabeceras para la API  
header("Access-Control-Allow-Origin: *"); // Geográficamente restringible  
header("Content-Type: application/json");  
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");  

// Función para obtener datos POST  
function getPost() {  
    return ($_SERVER["CONTENT_TYPE"] === "application/json") ?  
        json_decode(file_get_contents("php://input"), true) : $_POST;  
}  

// Instancia del controlador  
$controller = new Controller();  

// Manejo de solicitudes  
switch ($_SERVER["REQUEST_METHOD"]) {  
    case 'POST':  
        $post = getPost();  
        handlePostRequest($_GET["action"] ?? null, $post, $controller);  
        break;  

    case 'GET':  
        handleGetRequest($_GET["action"] ?? null, $controller);  
        break;  

    default:  
        http_response_code(405);  
        echo json_encode(["state" => false, "message" => "method not allowed"]);  
        break;  
}  

//POST  
function handlePostRequest($action, $post, Controller $controller) {  
    if (empty($action)) {  
        http_response_code(400);  
        echo json_encode(["state" => false, "message" => "action is required"]);  
        return;  
    }  

    switch ($action) {  
        case "login":  
            authenticateUser($post, $controller);  
            break;  

        case "signup":  
            registerUser($post, $controller);  
            break;  

        case "contact":  
            saveContact($post, $controller);  
            break;  

        default:  
            http_response_code(404);  
            echo json_encode(["state" => false, "message" => "action not found"]);  
            break;  
    }  
}  

//GET
function handleGetRequest($action, Controller $controller) {  
    if (empty($action)) {  
        http_response_code(400);  
        echo json_encode(["state" => false, "message" => "action is required"]);  
        return;  
    }  

    switch ($action) {  
        case "logout":  
            logout();  
            break;  

        case "redirect":  
            redirect();  
            break;  

        case "getusers":  
            getUserList($_GET["search"] ?? null, $controller);  
            break;  

        case "listcontacts":  
            getListContacts($controller);  
            break;  

        default:  
            http_response_code(404);  
            echo json_encode(["state" => false, "message" => "action not found"]);  
            break;  
    }  
}