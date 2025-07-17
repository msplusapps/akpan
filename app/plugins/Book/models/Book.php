<?php

namespace App\Plugins\Book\Models;

use Core\Model;

class Book extends Model
{
    protected static $table = 'akn_book';

    public int $id;
    public string $created_at;
    public string $updated_at;

    /**
     * Get all records
     */
    public static function all(): array
    {
        return (new static)->select("SELECT * FROM " . (new static)->prefix . static::$table);
    }

    /**
     * Find a record by ID
     */
    public static function find(int $id): ?array
    {
        $result = (new static)->select(
            "SELECT * FROM " . (new static)->prefix . static::$table . " WHERE id = :id LIMIT 1",
            ['id' => $id]
        );

        return $result[0] ?? null;
    }

    /**
     * Create a new record
     */
    public static function create(array $data): bool
    {
        return (new static)->insert($data);
    }

    /**
     * Update an existing record
     */
    public static function updateRecord(int $id, array $data): bool
    {
        return (new static)->update($id, $data);
    }

    /**
     * Delete a record by ID
     */
    public static function remove(int $id): bool
    {
        return (new static)->delete($id);
    }
}