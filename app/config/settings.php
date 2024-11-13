<?php  
require_once './vendor/autoload.php';  

use Dotenv\Dotenv;  

class Settings  
{  
    private $dsn;  
    private $user;  
    private $pass;  
    private $mode;  
    private $domain;

    public function __construct()
    {  
        Dotenv::createImmutable('./')->load();
        $this->dsn = $_ENV["DSN"] ?? null; 
        $this->user = $_ENV["USER"] ?? null;  
        $this->pass = $_ENV["PASS"] ?? null;  
        $this->mode = $_ENV["MODE"] ?? null; 
        $this->domain = $_ENV["DOMAIN"] ?? null;   
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

    public function getDomain()  
    {  
        return $this->domain;  
    }
}