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
            $this->jsonResponse(["state" => false, "message" => "An error occurred during signup: " . $th->getMessage()], 500);
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

                session_set_cookie_params([
                    'secure' => true,     
                    'httponly' => true,  
                    'samesite' => 'Strict',
                ]);
    
                session_start();

                $_SESSION["user"] = [
                    "create" => time(),
                    "ip" => $_SERVER['REMOTE_ADDR'],
                    "agent" => $_SERVER['HTTP_USER_AGENT'],
                    "id" => $response->getId(),
                    "username" => $response->getUsername(),
                    "email" => $response->getEmail(),
                    "rol" => $response->getRol(),
                    "state" => $response->getState(),
                ];
                
                $this->jsonResponse(["state" => true, "message" => "Login successful."], 200);
            } else {
                $this->jsonResponse(["state" => false, "message" => "Email or password incorrect."], 401);
            }
        } catch (\Throwable $th) {
            $this->jsonResponse(["state" => false, "message" => "An error occurred during login: " . $th->getMessage()], 500);
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
                        'rol' => $item->getRol(),
                        'state' => $item->getState()
                    ];
                }, $list);
                $this->jsonResponse(["state" => true, "users" => $jsonList], 200);
            } else {
                $this->jsonResponse(["state" => false, "message" => "No users found."], 404);
            }
        } catch (\Throwable $th) {
            $this->jsonResponse(["state" => false, "message" => "An error occurred: " . $th->getMessage()], 500);
            error_log($th->getMessage());
        }
    }

    function deleteUser(int $id)
    {
        try {
            $deleted = $this->userDao->deleteById($id);
            if ($deleted) {
                $this->jsonResponse(["state" => true, "message" => "User deleted successfully."], 200);
            } else {
                $this->jsonResponse(["state" => false, "message" => "User not found or could not be deleted."], 404);
            }
        } catch (\Throwable $th) {
            $this->jsonResponse(["state" => false, "message" => "An error occurred: " . $th->getMessage()], 500);
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
            $this->jsonResponse(["state" => false, "message" => "An error occurred while sending the contact form: " . $th->getMessage()], 500);
            error_log($th->getMessage());
        }
    }

    function updateStateUser(int $id, string $state)
    {
        try {
            $response = $this->userDao->updateState($id, $state);
            if ($response) {
                $this->jsonResponse(["state" => true, "message" => "User state update succes."], 200);
            } else {
                $this->jsonResponse(["state" => false, "message" => "Could not update user state."], 404);
            }
        } catch (\Throwable $th) {
            $this->jsonResponse(["state" => false, "message" => "An error occurred while sending the contact form: " . $th->getMessage()], 500);
            error_log($th->getMessage());
        }
    }

    public function updateProfile(int $id, string $user, string $email)
    {
        try {
            $response = $this->userDao->updateProfile($id, $user, $email);
            if ($response) {
                $_SESSION["user"]["username"] = $user;
                $_SESSION["user"]["email"] = $email;
                $this->jsonResponse(["state" => true, "message" => "User state profile succes."], 200);
            } else {
                $this->jsonResponse(["state" => false, "message" => "Could not update profile."], 404);
            }
        } catch (\Throwable $th) {
            $this->jsonResponse(["state" => false, "message" => "An error occurred while sending the contact form: " . $th->getMessage()], 500);
            error_log($th->getMessage());
        }
    }

    function getListContacts(string $search)
    {
        try {
            $response = $this->contactDao->getListContacts($search);
            if (!empty($response)) {
                $this->jsonResponse(["state" => true, "contacts" => $response], 200);
            } else {
                $this->jsonResponse(["state" => false, "message" => "No contacts found."], 404);
            }
        } catch (\Throwable $th) {
            $this->jsonResponse(["state" => false, "message" => "An error occurred: " . $th->getMessage()], 500);
            error_log($th->getMessage());
        }
    }
}
