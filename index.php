<?php  
require_once 'app/controller/controller.php';  
require_once 'app/model/user.php';  
require_once 'app/config/settings.php';  
require_once 'app/request.php';  
 
$config = new settings();
if ($config->getMode() == "DEVELOPMENT") {  
    ini_set('display_errors', 1);  
    ini_set('display_startup_errors', 1);  
    error_reporting(E_ALL);  
}  

header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");  
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");  


function getPost(){
    return ($_SERVER["CONTENT_TYPE"] === "application/json") ? 
    json_decode(file_get_contents("php://input"), true) : $_POST;
}

$controller = new controller(); 
  
switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':  
        $post = getPost();
        handlePostRequest($_GET["action"], $post, $controller);  
        break;  

    case 'GET':  
        handleGetRequest($_GET["action"]);  
        break;  

    default:  
        respondWithError(405, "Method Not Allowed");  
        break;  
}  

function handlePostRequest($action, $post, $controller) {  
    switch ($action) {  
        case "login":  
            authenticateUser($post, $controller);  
            break;  

        case "signup":  
            registerUser($post, $controller);  
            break;  

        default:  
            respondWithError(404, "Action not found");  
            break;  
    }  
}  

function handleGetRequest($action) {  
    if ($action === "logout") {  
        logout();
    } else {  
        respondWithError(404, "Action not found");  
    }  
}  