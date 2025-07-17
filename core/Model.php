<?php
namespace Core;

class Model extends Database
{
    protected $table; // Now non-static
    protected $prefix = 'akn_';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct(); // Initializes $this->pdo from Database
    }

    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->prefix . $this->table);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->prefix . $this->table . " WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function where($column, $value) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->prefix . $this->table . " WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $fields = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($f) => ":$f", array_keys($data)));

        $stmt = $this->pdo->prepare("INSERT INTO " . $this->prefix . $this->table . " ($fields) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    protected function select($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $updates = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $data[$this->primaryKey] = $id;

        $stmt = $this->pdo->prepare("UPDATE " . $this->prefix . $this->table . " SET $updates WHERE {$this->primaryKey} = :{$this->primaryKey}");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM " . $this->prefix . $this->table . " WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            if (getenv('DEBUG') === 'true') {
                die("SQL Execution Error: " . $e->getMessage());
            }
            return false;
        }
    }

    public function findOne($conditions) {
        $sql = "SELECT * FROM " . $this->prefix . $this->table . " WHERE ";
        $sql .= implode(' AND ', array_map(fn($c) => "$c = :$c", array_keys($conditions)));
        $sql .= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchObject(get_class($this));
    }

    public function save() {
        $data = [];
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, ['pdo', 'primaryKey', 'prefix', 'table'])) {
                $data[$key] = $value;
            }
        }

        if (isset($this->{$this->primaryKey})) {
            $this->update($this->{$this->primaryKey}, $data);
        } else {
            $this->insert($data);
        }
    }
}
