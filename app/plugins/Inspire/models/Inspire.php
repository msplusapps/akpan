<?php
namespace App\Plugins\Inspire\Models;

use Core\Model;

class Inspire extends Model
{
    protected $table = 'inspire';

    public int $id;
    public string $created_at;
    public string $updated_at;

    /**
     * Get all records
     */
    public function all(): array
    {
        return $this->select("SELECT * FROM {$this->prefix}{$this->table}");
    }

    /**
     * Find a record by ID
     */
    public function find($id)
    {
        $result = $this->select(
            "SELECT * FROM {$this->prefix}{$this->table} WHERE id = :id LIMIT 1",
            ['id' => $id]
        );
        return $result[0] ?? null;
    }

    /**
     * Create a new record
     */
    public function create(array $data): bool
    {
        return $this->insert($data);
    }

    /**
     * Update an existing record
     */
    public function updateRecord(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a record by ID
     */
    public function remove(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * ✅ Get a random quote
     */
    public function getRandomQuote(): ?array
    {
        $stmt = $this->pdo->query("SELECT message, author FROM {$this->prefix}{$this->table} ORDER BY RAND() LIMIT 1");
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
}