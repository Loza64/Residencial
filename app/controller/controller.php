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
            if ($response != null && password_verify($pass, $response["pass"])) {  
                session_start();  
                $_SESSION["user"] = [  
                    "id" => $response["id"],  
                    "username" => $response["username"],  
                    "email" => $response["email"],  
                    "rol" => $response["rol"]  
                ]; 
                http_response_code(200);  
                echo json_encode(["state" => true, "message" => "login succes."]);  
            } else {  
                http_response_code(401);  
                echo json_encode(["state" => false, "message" => "email incorrect."]);  
            } 
        } catch (\Throwable $th) {  
            http_response_code(500);  
            echo json_encode(["state" => false, "message" => "Internal server error."]);  
            error_log($th->getMessage()); // Log the error for debugging  
        }  
    }  

    function signUp($username, $email, $pass) {  
        try { 
            $response = $this->userdao->create($username, $email, $pass);  
            if ($response) {  
                http_response_code(201);  
                echo json_encode(["state" => true, "message" => "Signup successful."]);  
            } else {  
                http_response_code(409);  
                echo json_encode(["state" => false, "message" => "Username or email is already used."]);  
            }  
        } catch (\Throwable $th) {  
            http_response_code(500);  
            echo json_encode(["state" => false, "message" => "Internal server error."]);  
            error_log($th->getMessage()); // Log the error for debugging  
        }  
    }  
}  
?>