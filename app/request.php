<?php
require_once './app/middleware/validator.php';

//Post
function authenticateUser($post, Controller $controller)
{
    $errors = validateLogin($post);
    if (empty($post["email"]) || empty($post["pass"])) {
        errorResponse(400, "Missing email or password.");
    } else if (!empty($errors)) {
        errorResponse(400, $errors);
    } else {
        echo $controller->login($post["email"], $post["pass"]);
    }
}

function registerUser($post, Controller $controller)
{
    $errors = validateSignUp($post);
    if (empty($post["username"]) || empty($post["email"]) || empty($post["pass"])) {
        errorResponse(400, "Missing user, email or password.");
    } else if (!empty($errors)) {
        errorResponse(400, $errors);
    } else {
        $user = new User(null, $post["username"], $post["email"], $post["pass"]);
        echo $controller->signUp($user);
    }
}


//Get
function logout()
{
    session_start();
    session_destroy();
    http_response_code(200);
    echo json_encode(["state" => true, "message" => "Session closed"]);
}

//Error
function errorResponse($code, $message)
{
    http_response_code($code);
    echo json_encode(["state" => false, "message" => $message]);
    exit();
}
