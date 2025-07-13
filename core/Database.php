<?php

class Database
{
    protected $pdo;

    public function __construct()
    {
        $this->connect();
    }

    protected function connect()
    {
        try {
            $host = $_ENV['DB_HOST'];
            $name = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";

            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("[DB CONNECTION FAILED] " . $e->getMessage());
            exit("Database connection error");
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
