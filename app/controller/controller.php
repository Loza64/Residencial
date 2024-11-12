<?php
require_once './app/model/user.php';

class controller
{

    private $userDao;

    function __construct()
    {
        $this->userDao = new user();
    }

    function signUp(user $user)
    {
        try {
            $response = $this->userDao->create($user);
            if ($response) {
                http_response_code(201);
                echo json_encode(["state" => true, "message" => "Signup successful."]);
            } else {
                http_response_code(409);
                echo json_encode(["state" => false, "message" => "Username or email is already used."]);
            }
        } catch (\Throwable $th) {
            http_response_code(505);
            echo json_encode(["state" => false, "message" => $th->getMessage()]);
            error_log($th->getMessage());
        }
    }

    function login($email, $pass)
    {
        try {
            $response = $this->userDao->findByEmail($email);
            if ($response != null && $response->verifyPassword($pass)) {
                session_start();
                $_SESSION["user"] = [
                    "id" => $response->getId(),
                    "username" => $response->getUsername(),
                    "email" => $response->getEmail(),
                    "rol" => $response->getRol()
                ];
                http_response_code(200);
                echo json_encode(["state" => true, "message" => "login succes."]);
            } else {
                http_response_code(401);
                echo json_encode(["state" => false, "message" => "email or password incorrect."]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["state" => false, "message" => $th->getMessage()]);
            error_log($th->getMessage());
        }
    }

}
