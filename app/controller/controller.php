<?php  
require_once './app/model/user.php';  
require_once './app/model/contact.php';  

class Controller  
{  
    private $userDao;  
    private $contactDao;  

    function __construct()  
    {  
        $this->userDao = new User();  
        $this->contactDao = new Contact();  
    }  

    private function jsonResponse($data, $statusCode = 200)  
    {  
        http_response_code($statusCode);  
        echo json_encode($data);  
    }  

    function signUp(User $user)  
    {  
        try {  
            $response = $this->userDao->create($user);  
            if ($response) {  
                $this->jsonResponse(["state" => true, "message" => "Signup successful."], 201);  
            } else {  
                $this->jsonResponse(["state" => false, "message" => "Username or email is already used."], 409);  
            }  
        } catch (\Throwable $th) {  
            $this->jsonResponse(["state" => false, "message" => "An error occurred during signup."], 500);  
            error_log($th->getMessage());  
        }  
    }  

    function login($email, $pass)  
    {  
        try {  
            if (empty($email) || empty($pass)) {  
                $this->jsonResponse(["state" => false, "message" => "Email and password are required."], 400);  
                return;  
            }  

            $response = $this->userDao->findByEmail($email);  
            if ($response != null && $response->verifyPassword($pass)) {  
                session_start();  
                $_SESSION["user"] = [  
                    "id" => $response->getId(),  
                    "username" => $response->getUsername(),  
                    "email" => $response->getEmail(),  
                    "rol" => $response->getRol()  
                ];  
                $this->jsonResponse(["state" => true, "message" => "Login successful."], 200);  
            } else {  
                $this->jsonResponse(["state" => false, "message" => "Email or password incorrect."], 401);  
            }  
        } catch (\Throwable $th) {  
            $this->jsonResponse(["state" => false, "message" => "An error occurred during login."], 500);  
            error_log($th->getMessage());  
        }  
    }  

    function getUserList(?string $search)  
    {  
        try {  
            $list = $this->userDao->getUserList($search);  
            if (!empty($list)) {  
                $jsonList = array_map(function ($item) {  
                    return [  
                        'id' => $item->getId(),  
                        'username' => $item->getUsername(),  
                        'email' => $item->getEmail(),  
                        'rol' => $item->getRol()  
                    ];  
                }, $list);  
                $this->jsonResponse(["state" => true, "users" => $jsonList], 200);  
            } else {  
                $this->jsonResponse(["state" => false, "message" => "No users found."], 404);  
            }  
        } catch (\Throwable $th) {  
            $this->jsonResponse(["state" => false, "message" => "An error occurred."], 500);  
            error_log($th->getMessage());  
        }  
    }
    
    function deleteUser(int $id){  
        try {  
            $deleted = $this->userDao->deleteById($id);  
            if($deleted) {  
                $this->jsonResponse(["state" => true, "message" => "User deleted successfully."], 200);  
            } else {  
                $this->jsonResponse(["state" => false, "message" => "User not found or could not be deleted."], 404);  
            }  
        } catch (\Throwable $th) {  
            $this->jsonResponse(["state" => false, "message" => "An error occurred."], 500);  
            error_log($th->getMessage());   
        }  
    }

    function newContact(Contact $contact)  
    {  
        try {  
            $response = $this->contactDao->create($contact);  
            if ($response) {  
                $this->jsonResponse(["state" => true, "message" => "Contact form submitted successfully."], 201);  
            } else {  
                $this->jsonResponse(["state" => false, "message" => "You have already sent this contact form."], 409);  
            }  
        } catch (\Throwable $th) {  
            $this->jsonResponse(["state" => false, "message" => "An error occurred while sending the contact form."], 500);  
            error_log($th->getMessage());  
        }  
    }  

    function getListContacts()  
    {  
        try {  
            $response = $this->contactDao->getListContacts();  
            if (!empty($response)) {  
                $this->jsonResponse(["state" => true, "contacts" => $response], 200);  
            } else {  
                $this->jsonResponse(["state" => false, "message" => "No contacts found."], 404);  
            }  
        } catch (\Throwable $th) {  
            $this->jsonResponse(["state" => false, "message" => "An error occurred."], 500);  
            error_log($th->getMessage());  
        }  
    }  
}