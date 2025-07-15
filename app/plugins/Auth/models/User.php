 
<?php



use Core\Model; // ✅ this line imports the base Model

class Users extends Model {
    protected $table = 'msk_users';

    // Get all users
    public function all(){
        $sql = "SELECT * FROM " . static::$table;
        return $this->select($sql);
    }

    // Find user by ID
    public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->select($sql, [$id])[0] ?? null;
    }

    // Find user by email
    public function findOne($value, $column = 'id'){
        $allowedColumns = ['email', 'username', 'id'];
        if (!in_array($column, $allowedColumns)) {
            throw new Exception("Invalid column: $column");
        }
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1";
        return $this->select($sql, [$value])[0] ?? null;
    }


    // Create new user
    public function create($data){
        $sql = "INSERT INTO {$this->table} (name, email, username, password) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [
            $data['name'],
            $data['email'],
            $data['username'],
            encrypt($data['password'])
        ]);
    }

    // Update user
    public function update($id, $data){
        $sql = "UPDATE {$this->table} SET name = ?, email = ? WHERE id = ?";
        return $this->execute($sql, [$data['name'], $data['email'], $id]);
    }

    // Delete user
    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
