<?php
namespace App\Models;

use Core\Model;
use Core\Security;
use Exception;

class User extends Model {
    protected $table = 'msk_users';

    public function all() {
        $sql = "SELECT * FROM " . $this->table;
        return $this->select($sql);
    }

    public function find($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";
        return $this->select($sql, [$id])[0] ?? null;
    }

    public function findOne($value, $column = 'id') {
        $allowed = ['id', 'email', 'username'];
        if (!in_array($column, $allowed)) {
            throw new Exception("Invalid column: $column");
        }
        $sql = "SELECT * FROM " . $this->table . " WHERE {$column} = ? LIMIT 1";
        return $this->select($sql, [$value])[0] ?? null;
    }

    public function create($data) {
        $sql = "INSERT INTO " . $this->table . " (name, email, username, password) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [
            $data['name'],
            $data['email'],
            $data['username'],
            $data['password']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE " . $this->table . " SET name = ?, email = ? WHERE id = ?";
        return $this->execute($sql, [$data['name'], $data['email'], $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
