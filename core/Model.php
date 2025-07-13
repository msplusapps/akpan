<?php

class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $pdo;

    public function __construct()
    {
        $this->pdo = $this->connect();
    }

    protected function connect()
    {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        try {
            return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    public function all()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function where($column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $fields = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($f) => ":$f", array_keys($data)));

        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($fields) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $updates = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $data[$this->primaryKey] = $id;

        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $updates WHERE {$this->primaryKey} = :{$this->primaryKey}");
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}
