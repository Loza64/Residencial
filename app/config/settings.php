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
    private $dbport;

    public function __construct()
    {
        Dotenv::createImmutable('./')->load();
        $this->user = $_ENV["USER"] ?? null;
        $this->pass = $_ENV["PASS"] ?? null;
        $this->mode = $_ENV["MODE"] ?? null;
        $this->dbport = $_ENV["DBPORT"] ?? 3306;
        $this->domain = $_ENV["DOMAIN"] ?? null;
        $this->dsn = "mysql:host={$this->domain};port={$this->dbport};dbname=residencial;charset=utf8mb4";
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
