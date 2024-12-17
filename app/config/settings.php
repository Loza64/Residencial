<?php
require_once './vendor/autoload.php';

use Dotenv\Dotenv;

class Settings
{
    private $domain;
    private $mode;
    private $dsn;
    private $user;
    private $pass;

    public function __construct()
    {
        Dotenv::createImmutable('.')->load();
        $this->domain = $_ENV["DOMAIN"] ?? "localhost";
        $this->mode = $_ENV["MODE"] ?? 'development';
        $this->user = $_ENV["USER"] ?? null;
        $this->pass = $_ENV["PASS"] ?? null;
        $this->dsn = $_ENV["DSN"] ?? null;

        if (empty($this->user) || empty($this->pass) || empty($this->dsn)) {
            throw new Exception("Config incomplete");
        }
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
