<?php
require_once './app/middleware/validator.php';
require_once './app/model/user.php';
require_once './app/config/settings.php';

function userSession(): ?User
{
    session_start();

    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];

        if ($user["ip"] != $_SERVER["REMOTE_ADDR"]) {
            session_unset();
            session_destroy();
            error_log("Hacking attempt detected: IP mismatch");
            return null;
        }

        if ($user["agent"] != $_SERVER["HTTP_USER_AGENT"]) {
            error_log("Hacking attempt detected: User agent mismatch");
            return null;
        }

        if (time() - $user["create"] > 1800) {
            session_unset();
            session_destroy();
            return null;
        }

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
    header('Location: /public/login.php');
    exit;
}

function redirect()
{
    $config = new Settings();;
    $user = userSession();
    if ($user) {
        if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
            header("Location: https://{$config->getDomain()}/app/view/dashboard.php");
        } else {
            header("Location: https://{$config->getDomain()}/app/view/inicio.php");
        }
    } else {
        header("Location: https://{$config->getDomain()}/public/login.php");
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

    if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
        $controller->getUserList($search);
    } else {
        sendJsonResponse(403, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}

function updateStateUser(int $id, string $state, Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    $errorint = validateParameterInt($id);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errorint["parameter"]]);
        return;
    }

    $errorstring = validateParameter($state);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errorstring["parameter"]]);
        return;
    }

    if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
        if ($user->getId() === $id) {
            sendJsonResponse(403, ["state" => false, "message" => "You cannot update your self."]);
        } else {
            $controller->updateStateUser($id, $state);
        }
    } else {
        sendJsonResponse(403, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}

function updateProfile($put, Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    $errors = validateProfile($put);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errors]);
        return;
    }

    $controller->updateProfile($user->getId(), $put["username"], $put["email"]);
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
        if ($user->getId() === $id) {
            sendJsonResponse(403, ["state" => false, "message" => "You cannot deleted your self."]);
        } else {
            $controller->deleteUser($id);
        }
    } else {
        sendJsonResponse(403, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}


function getListContacts(string $search, Controller $controller)
{
    $user = userSession();
    if (!$user) {
        sendJsonResponse(401, ["state" => false, "message" => "Your session has expired."]);
        return;
    }

    $errorstring = validateParameter($search);
    if (!empty($errors)) {
        sendJsonResponse(400, ["state" => false, "message" => $errorstring["parameter"]]);
        return;
    }

    if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
        $controller->getListContacts($search);
    } else {
        sendJsonResponse(403, ["state" => false, "message" => "You are not granted permission for this request."]);
    }
}
