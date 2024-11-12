<?php
require_once './app/middleware/validator.php';
require_once './app/model/user.php';

function userSession(): ?User
{
    session_start();
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        return new User(
            $user["id"],
            $user["username"],
            $user["email"],
            null,
            $user["rol"]
        );
    } else {
        return null;
    }
}

//Post
function authenticateUser($post, Controller $controller)
{
    $errors = validateLogin($post);
    if (!empty($errors)) {
        errorResponse(400, $errors);
    } else {
        echo $controller->login($post["email"], $post["pass"]);
    }
}

function registerUser($post, Controller $controller)
{
    $errors = validateSignUp($post);
    if (!empty($errors)) {
        errorResponse(400, $errors);
    } else {
        $user = new User(null, $post["username"], $post["email"], $post["pass"]);
        echo $controller->signUp($user);
    }
}

function saveContact($post, Controller $controller)
{
    $errors = validateContact($post);
    if (!empty($errors)) {
        errorResponse(400, $errors);
    } else {
        $contact = new Contact(
            0,
            $post["iduser"],
            $post["name"],
            new DateTime($post["birth"]),
            $post["dui"],
            $post["email"],
            $post["phone"],
            $post["address"],
            $post["occupation"],
            (float)$post["income"],
            (int)$post["family_members"],
            $post["reason_interest"],
            $post["personal_reference"],
            new DateTime($post["application_date"])
        );
        $controller->newContact($contact);
    }
}


//Get
function logout()
{
    session_start();
    session_destroy();
    header('Location: /residencial/public/login.php');
}

function redirect()
{
    $user = userSession();
    if ($user != null) {
        $role = $user->getRol();
        if ($role === "resident" || $role === "s_admin" || $role === "admin") {
            header('Location: /residencial/app/view/inicio.php');
            exit;
        }

        header('Location: ./view/error.php');
        exit;
    } else {
        header('Location: /residencial/public/login.php');
        exit;
    }
}

//Error
function errorResponse($code, $message)
{
    http_response_code($code);
    echo json_encode(["state" => false, "message" => $message]);
    exit();
}
