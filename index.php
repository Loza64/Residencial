<?php
require_once 'app/controller/controller.php';
require_once 'app/config/settings.php';
require_once 'app/request.php';

$config = new Settings();
if ($config->getMode() == "DEVELOPMENT") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (
    strcmp($_SERVER['REQUEST_URI'], '') === 0 ||
    strcmp($_SERVER['REQUEST_URI'], '/') === 0 ||
    strcmp($_SERVER['REQUEST_URI'], '/index.php') === 0
) {
    header("Location: /public/login.php");
    exit();
}

header("Access-Control-Allow-Origin: https://{$config->getDomain()}");

header_remove('Server');
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Access-Control-Allow-Credentials: true");
header("Content-Security-Policy: frame-ancestors 'none';");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Permissions-Policy: geolocation=(self), microphone=(), camera=(), fullscreen=(self)");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 204 No Content");
    exit();
}

function getPost()
{
    return ($_SERVER["CONTENT_TYPE"] === "application/json") ?
        json_decode(file_get_contents("php://input"), true) : $_POST;
}

$controller = new Controller();

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':
        $post = getPost();
        handlePostRequest($_GET["action"] ?? null, $post, $controller);
        break;
    case 'GET':
        handleGetRequest($_GET["action"] ?? null, $controller);
        break;
    case 'PATCH':
        handlePatchRequest($_GET["action"] ?? null, $controller);
        break;
    case 'PUT':
        handlePutRequest($_GET["action"] ?? null, $controller);
        break;
    case 'DELETE':
        handleDeleteRequest($_GET["action"] ?? null, $controller);
        break;
    default:
        http_response_code(405);
        echo json_encode(["state" => false, "message" => "Method not allowed"]);
        break;
}

function handlePostRequest($action, $post, Controller $controller)
{
    if (empty($action)) {
        http_response_code(400);
        echo json_encode(["state" => false, "message" => "Action is required"]);
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
            echo json_encode(["state" => false, "message" => "Action not found"]);
            break;
    }
}

function handleGetRequest($action, Controller $controller)
{
    if (empty($action)) {
        http_response_code(400);
        echo json_encode(["state" => false, "message" => "Action is required"]);
        return;
    }

    switch ($action) {
        case "logout":
            logout();
            break;
        case "redirect":
            redirect();
            break;
        case "users":
            getUserList($_GET["search"] ?? null, $controller);
            break;
        case "contacts":
            getListContacts($_GET["search"], $controller);
            break;
        default:
            http_response_code(404);
            echo json_encode(["state" => false, "message" => "Action not found"]);
            break;
    }
}

function handlePatchRequest($action, Controller $controller)
{
    if (empty($action)) {
        http_response_code(400);
        echo json_encode(["state" => false, "message" => "Action is required"]);
        return;
    }

    switch ($action) {
        case "updateuser":
            updateStateUser($_GET["id"] ?? 0, $_GET["state"], $controller);
            break;
        default:
            http_response_code(404);
            echo json_encode(["state" => false, "message" => "Action not found"]);
            break;
    }
}

function handlePutRequest($action, Controller $controller)
{
    if (empty($action)) {
        http_response_code(400);
        echo json_encode(["state" => false, "message" => "Action is required"]);
        return;
    }

    switch ($action) {
        case "updateprofile":
            $post = getPost();
            updateProfile($post, $controller);
            break;
        default:
            http_response_code(404);
            echo json_encode(["state" => false, "message" => "Action not found"]);
            break;
    }
}

function handleDeleteRequest($action, Controller $controller)
{
    if (empty($action)) {
        http_response_code(400);
        echo json_encode(["state" => false, "message" => "Action is required"]);
        return;
    }

    switch ($action) {
        case "deleteduser":
            deleteUser($_GET["id"] ?? 0, $controller);
            break;
        default:
            http_response_code(404);
            echo json_encode(["state" => false, "message" => "Action not found"]);
            break;
    }
}
