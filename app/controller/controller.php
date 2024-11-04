<?php   
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/model/dao/userDAO.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/app/model/entities/user.php';  

class controller {  
    
    private $userdao;  

    function __construct() {  
        $this->userdao = new userDAO();  
    }  

    function login($email, $pass) {  
        try {  
            $response = $this->userdao->findByEmail($email);  
            if ($response && password_verify($pass, $response["pass"])) {  
                session_start();  
                $_SESSION["user"] = [  
                    "id" => $response["id"],  
                    "username" => $response["username"],  
                    "email" => $response["email"],  
                    "rol" => $response["rol"]  
                ];  
                http_response_code(200);  
                echo json_encode(["state" => true, "message" => "Login successful."]);  
            } else {  
                http_response_code(401);  
                echo json_encode(["state" => false, "message" => "Email or password incorrect."]);  
            }  
        } catch (\Throwable $th) {  
            http_response_code(500);  
            echo json_encode(["state" => false, "message" => "Internal server error."]);  
            error_log($th->getMessage()); // Log the error for debugging  
        }  
    }  

    function signUp($username, $email, $pass) {  
        try {  
            // Revisar si el email o username ya existen antes de crear el usuario  
            $existingUser = $this->userdao->findByEmail($email);  
            if ($existingUser) {  
                http_response_code(409);  
                echo json_encode(["state" => false, "message" => "Email already exists."]);  
                return; 
            }  

            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);  
            $response = $this->userdao->create($username, $email, $hashedPassword);  
            if ($response) {  
                http_response_code(201); // 201 Created  
                echo json_encode(["state" => true, "message" => "Signup successful."]);  
            } else {  
                http_response_code(500);  
                echo json_encode(["state" => false, "message" => "Failed to create user."]);  
            }  
        } catch (\Throwable $th) {  
            http_response_code(500);  
            echo json_encode(["state" => false, "message" => "Internal server error."]);  
            error_log($th->getMessage()); // Log the error for debugging  
        }  
    }  
}  
?>