<?php

namespace App\Plugins\Song\Models;

use Core\Model;

class Song extends Model
{
    protected static $table = 'akn_songs';

    public int $id;
    public string $title;
    public string $artist;
    public ?string $album = null;
    public string $created_at;
    public string $updated_at;

    /**
     * Get all songs
     */
    public static function all(): array
    {
        return (new static)->select("SELECT * FROM " . (new static)->prefix . static::$table);
    }

    /**
     * Find a song by ID
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
     * Create a new song
     */
    public static function create(array $data): bool
    {
        return (new static)->insert([
            'title' => $data['title'],
            'artist' => $data['artist'],
            'album' => $data['album'] ?? null,
        ]);
    }

    /**
     * Update an existing song
     */
    public static function updateSong(int $id, array $data): bool
    {
        return (new static)->update($id, [
            'title' => $data['title'],
            'artist' => $data['artist'],
            'album' => $data['album'] ?? null,
        ]);
    }

    /**
     * Delete a song by ID
     */
    public static function remove(int $id): bool
    {
        return (new static)->delete($id);
    }

}
