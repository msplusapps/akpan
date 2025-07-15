<?php
namespace Core;


class Database{
    protected $pdo;

    public function __construct(){
        $this->connect();
    }

    protected function connect(){
        try {
            $host = env('DB_HOST');
            $name = env('DB_NAME');
            $user = env('DB_USER');
            $pass = env('DB_PASS');
            $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";

            $this->pdo = new \PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch (\PDOException $e) {
            error_log("[DB CONNECTION FAILED] " . $e->getMessage());
            exit("Database connection error: " . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}
