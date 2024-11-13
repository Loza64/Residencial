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
        http_response_code(400);
        echo json_encode(["state" => false, "message" => $errors]);
    } else {
        echo $controller->login($post["email"], $post["pass"]);
    }
}

function registerUser($post, Controller $controller)
{
    $errors = validateSignUp($post);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["state" => false, "message" => $errors]);
    } else {
        $user = new User(null, $post["username"], $post["email"], $post["pass"]);
        echo $controller->signUp($user);
    }
}

function saveContact($post, Controller $controller)
{
    $user = userSession();
    if ($user) {
        $errors = validateContact($post);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(["state" => false, "message" => $errors]);
        } else {
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
    } else {
        http_response_code(401);
        echo json_encode(["state" => false, "message" => "Your session has been  expired."]);
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

function getUserList(?string $search, Controller $controller)
{
    $user = userSession();
    if ($user) {
        $errors = validateParameter($search);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(["state" => false, "message" => $errors]);
        } else {
            if ($user->getRol() === "s_admin") {
                $controller->getUserList($search);
            } else {
                http_response_code(401);
                echo json_encode(["state" => false, "message" => "Your not granted permission to this request "]);
            }
        }
    } else {
        http_response_code(401);
        echo json_encode(["state" => false, "message" => "Your session has been  expired."]);
    }
}

function getListContacts(Controller $controller)
{
    $user = userSession();
    if ($user) {
        if ($user->getRol() === "s_admin" || $user->getRol() === "admin") {
            $controller->getListContacts();
        } else {
            http_response_code(401);
            echo json_encode(["state" => false, "message" => "Your not granted permission to this request "]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["state" => false, "message" => "Your session has been  expired."]);
    }
}
