 
<?php

class User extends Model
{
    protected $table = 'users';

    // Get all users
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->select($sql);
    }

    // Find user by ID
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->select($sql, [$id])[0] ?? null;
    }

    // Find user by email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->select($sql, [$email])[0] ?? null;
    }

    // Create new user
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (?, ?, ?)";
        return $this->execute($sql, [
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    // Update user
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET name = ?, email = ? WHERE id = ?";
        return $this->execute($sql, [$data['name'], $data['email'], $id]);
    }

    // Delete user
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
