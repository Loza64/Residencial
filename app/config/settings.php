<?php  
require_once $_SERVER['DOCUMENT_ROOT'] . '/residencial/vendor/autoload.php';  

use Dotenv\Dotenv;  

class settings  
{  
    private $dsn;  
    private $user;  
    private $pass;  
    private $mode;  

    public function __construct()
    {  
        Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/residencial')->load();
        $this->dsn = $_ENV["DSN"] ?? null; 
        $this->user = $_ENV["USER"] ?? null;  
        $this->pass = $_ENV["PASS"] ?? null;  
        $this->mode = $_ENV["MODE"] ?? null;  
    }  

    public function getDsn()  
    {  
        return $this->dsn;  
    }  

    public function getUser()  
    {  
        return $this->user;  
    }  

    public function getPass()  
    {  
        return $this->pass;  
    }  

    public function getMode()  
    {  
        return $this->mode;  
    }  
}