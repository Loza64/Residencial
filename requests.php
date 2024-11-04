<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'app/controller/controller.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");

// Función para obtener datos de entrada en JSON o en formato x-www-form-urlencoded
function getInputData() {
    // Si el tipo de contenido es JSON
    if (isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
        $data = json_decode(file_get_contents("php://input"), true); // Leer y decodificar JSON
    } else {
        // En caso de x-www-form-urlencoded o multipart/form-data, utilizamos $_POST
        $data = $_POST;
    }
    return $data;
}

$data = getInputData(); // Obtener los datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($data["action"])) { // Cambiado para soportar ambos métodos
    try {
        $controller = new controller();

        switch ($data["action"]) { // Cambiado para usar $data
            case 'login':
                if (!isset($data["email"], $data["pass"])) {
                    http_response_code(400);
                    echo json_encode(["state" => false, "message" => "Missing email or password."]);
                    break;
                }
                $email = $data["email"];
                $pass = $data["pass"];
                $result = $controller->login($email, $pass);
                if ($result) {
                    http_response_code(200);
                    echo json_encode(["state" => true, "message" => "Login successful."]);
                } else {
                    http_response_code(401);
                    echo json_encode(["state" => false, "message" => "Email or password incorrect."]);
                }
                break;

            case 'signup':
                if (!isset($data["user"], $data["email"], $data["pass"])) {
                    http_response_code(400);
                    echo json_encode(["state" => false, "message" => "Missing user, email, or password."]);
                    break;
                }
                $username = $data["user"];
                $email = $data["email"];
                $pass = $data["pass"];
                $result = $controller->signUp($username, $email, $pass);
                if ($result) {
                    http_response_code(200);
                    echo json_encode(["state" => true, "message" => "Signup successful."]);
                } else {
                    http_response_code(401);
                    echo json_encode(["state" => false, "message" => "Signup failed. Email or username may already exist."]);
                }
                break;

            default:
                http_response_code(400);
                echo json_encode(["state" => false, "message" => "Action not found"]);
                break;
        }
    } catch (\Throwable $th) {
        http_response_code(500);
        echo json_encode(["state" => false, "message" => "Internal server error."]);
        error_log($th);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"])) {
    $controller = new controller();

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
