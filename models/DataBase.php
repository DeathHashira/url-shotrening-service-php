<?php

namespace Models;

use PDO;

class DataBase
{
    private PDO $conn;
    public function __construct(
        private string $dbName,
        private string $dbHost,
        private string $dbUser,
        private string $dbPass
    ) {
        $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function createFromEnv(): self
    {
        return new self($_ENV["DB_NAME"], $_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
