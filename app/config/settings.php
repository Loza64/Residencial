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
    private $dbhost;
    private $dbport;

    public function __construct()
    {
        Dotenv::createImmutable('./')->load();
        //APP
        $this->domain = $_ENV["DOMAIN"] ?? "localhost";
        $this->mode = $_ENV["MODE"] ?? null;

        //DATABASE
        $this->user = $_ENV["USER"] ?? null;
        $this->pass = $_ENV["PASS"] ?? null;
        $this->dsn = "mysql:host=" . ($_ENV['HOST'] ?? 'localhost') . ";port=3306;dbname=residencial;charset=utf8mb4";;
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
