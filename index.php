<?php  

// Muestra errores en modo desarrollo  
//ini_set('display_errors', 1);  
//ini_set('display_startup_errors', 1);  
//error_reporting(E_ALL);  

require_once 'app/controller/controller.php';  
require_once 'app/model/entities/user.php';  

session_start();  
if (isset($_SESSION['user'])) {  
    header('Location: app/view/dashboard.php');   
    exit();
}else{
    header('Location: public/login.php'); 
}  

header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");  
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  

function getInputData() {  
    if (isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {  
        return json_decode(file_get_contents("php://input"), true);  
    }  
    return $_POST;  
}  

$data = getInputData();  
$controller = new controller();  

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET["action"])) {   
    switch ($_GET["action"]) {   
        case 'login':  
            if (!isset($data["email"], $data["pass"])) {  
                http_response_code(400);  
                echo json_encode(["state" => false, "message" => "Missing email or password."]);  
                break;  
            }  
            echo $controller->login($data["email"], $data["pass"]);  
            break;  

        case 'signup':  
            if (!isset($data["user"], $data["email"], $data["pass"])) {  
                http_response_code(400);  
                echo json_encode(["state" => false, "message" => "Missing user, email, or password."]);  
                break;  
            }  
            echo $controller->signUp($data["user"], $data["email"], $data["pass"]);  
            break;  

        default:  
            http_response_code(400);  
            echo json_encode(["state" => false, "message" => "Action not found"]);  
            break;  
    }  
} 

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"])) {  
    switch ($_GET["action"]) {  
        case 'hola':  
            http_response_code(200);  
            echo json_encode(["state" => true, "message" => "Hola"]);  
            break;  

        default:  
            http_response_code(400);  
            echo json_encode(["state" => false, "message" => "Action not found"]);  
            break;  
    }  
} 

?>