<?php
namespace Core;

class Model extends Database
{
    protected static $table;
    protected $prefix = 'akn_';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct(); // Initializes $this->pdo from Database
    }

    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->prefix . static::$table);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->prefix . static::$table . " WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function where($column, $value) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->prefix . static::$table . " WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $fields = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($f) => ":$f", array_keys($data)));

        $stmt = $this->pdo->prepare("INSERT INTO " . $this->prefix . static::$table . " ($fields) VALUES ($placeholders)");
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

        $stmt = $this->pdo->prepare("UPDATE " . $this->prefix . static::$table . " SET $updates WHERE {$this->primaryKey} = :{$this->primaryKey}");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM " . $this->prefix . static::$table . " WHERE {$this->primaryKey} = :id");
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

    public static function findOne($conditions) {
        $class = get_called_class();
        $instance = new $class();
        $tableName = $instance->prefix . static::$table;

        $sql = "SELECT * FROM {$tableName} WHERE ";
        $sql .= implode(' AND ', array_map(fn($c) => "$c = :$c", array_keys($conditions)));
        $sql .= " LIMIT 1";

        $stmt = $instance->pdo->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchObject($class);
    }

    public function save() {
        $class = get_called_class();
        $tableName = static::$table;
        $primaryKey = $this->primaryKey;

        $data = [];
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, ['pdo', 'primaryKey'])) {
                $data[$key] = $value;
            }
        }

        if (isset($this->$primaryKey)) {
            // Update
            $this->update($this->$primaryKey, $data);
        } else {
            // Insert
            $this->insert($data);
        }
    }
}
