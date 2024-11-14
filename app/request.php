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
    }
    return null;
}

function sendJsonResponse(int $status, $data)
{
    http_response_code($status);
    echo json_encode($data);
}

function authenticateUser($post, Controller $controller)
{
    $errors = validateLogin($post);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errors]);
    } else {
        $controller->login($post["email"], $post["pass"]);
    }
}

function registerUser($post, Controller $controller)
{
    $errors = validateSignUp($post);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errors]);
    } else {
        $user = new User(null, $post["username"], $post["email"], $post["pass"]);
        $controller->signUp($user);
    }
}

function saveContact($post, Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    $errors = validateContact($post);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errors]);
        return;
    }

    $contact = new Contact(
        null,
        $user->getId(),
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

function logout()
{
    session_start();
    session_destroy();
    header('Location: /residencial/public/login.php');
    exit;
}

function redirect()
{
    $user = userSession();
    if ($user) {
        if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
            header('Location: /residencial/app/view/dashboard.php');
        } else {
            header('Location: /residencial/app/view/inicio.php');
        }
    } else {
        header('Location: /residencial/public/login.php');
    }
    exit;
}

function getUserList(?string $search, Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    $errors = validateParameter($search);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errors["parameter"]]);
        return;
    }

    if ($user->getRol() === "s_admin") {
        $controller->getUserList($search);
    } else {
        sendJsonResponse(401, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}

function deleteUser(int $id, Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    $errors = validateParameterInt($id);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errors["parameter"]]);
        return;
    }

    if ($user->getRol() === "s_admin") {
        $controller->deleteUser($id);
    } else {
        sendJsonResponse(401, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}


function getListContacts(Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
        $controller->getListContacts();
    } else {
        sendJsonResponse(401, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}
