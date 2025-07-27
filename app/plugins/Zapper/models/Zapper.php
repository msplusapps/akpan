<?php

namespace App\Plugins\Zapper\Models;
use Core\Model;
class Zapper extends Model
{
    protected $table = 'zapper';
    public int $id;
    public string $session_id;
    public ?string $type = null;
    public int $is_active = 1;
    public string $status = 'waiting';
    public ?string $response = null;
    public ?int $user_id = null;
    public ?string $ip_address = null;
    public ?string $device_info = null;
    public string $created_at;
    public string $updated_at;
    public function getAll(): array
    {
        return $this->select("SELECT * FROM {$this->prefix}{$this->table}");
    }
    public function findById(int $id): ?array
    {
        $result = $this->select(
            "SELECT * FROM {$this->prefix}{$this->table} WHERE id = :id LIMIT 1",
            ['id' => $id]
        );
        return $result[0] ?? null;
    }
    public function findBySession(string $session_id): ?array
    {
        $result = $this->select(
            "SELECT * FROM {$this->prefix}{$this->table} WHERE session_id = :session_id LIMIT 1",
            ['session_id' => $session_id]
        );
        return $result[0] ?? null;
    }
    public function findByDeviceId(string $device_id): ?array
    {
        $result = $this->select(
            "SELECT * FROM {$this->prefix}{$this->table} WHERE device_info = :device_id LIMIT 1",
            ['device_id' => $device_id]
        );
        return $result[0] ?? null;
    }
    public function findActiveBySession(string $session_id): ?array
    {
        $result = $this->select(
            "SELECT * FROM {$this->prefix}{$this->table} WHERE session_id = :session_id AND is_active = 1 LIMIT 1",
            ['session_id' => $session_id]
        );
        return $result[0] ?? null;
    }
    public function create(array $data): bool
    {
        return $this->insert($data);
    }
    public function updateById(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }
    public function updateBySession(string $session_id, array $data): bool
    {
        return $this->rawUpdate(
            "UPDATE {$this->prefix}{$this->table} SET " . $this->buildSet($data) . " WHERE session_id = :session_id",
            array_merge($data, ['session_id' => $session_id])
        );
    }
     public function updateByDeviceId(string $device_id, array $data): bool
    {
        return $this->rawUpdate(
            "UPDATE {$this->prefix}{$this->table} SET " . $this->buildSet($data) . " WHERE device_info = :device_id",
            array_merge($data, ['device_id' => $device_id])
        );
    }
    public function deleteById(int $id): bool
    {
        return $this->delete($id);
    }
    public function deleteBySession(string $session_id): bool
    {
        return $this->rawDelete(
            "DELETE FROM {$this->prefix}{$this->table} WHERE session_id = :session_id",
            ['session_id' => $session_id]
        );
    }
    public function wipe(): bool
    {
        return $this->format();
    }
}
