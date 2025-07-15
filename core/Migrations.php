<?php
namespace Core;

class Migrations extends Database
{
    protected $migrationsPath = __DIR__ . '/../app/migrations';

    public function __construct(){
        parent::__construct(); // Connect DB

        if (!$this->pdo) {
            $this->logConsole("❌ PDO not available. Aborting migration.");
            return;
        }
        $this->createMigrationsTable();
        $this->runPendingMigrations();
    }

    protected function createMigrationsTable(){
        $sql = "CREATE TABLE IF NOT EXISTS msk_migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) UNIQUE,
            migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            $this->logConsole("❌ Failed to create migrations table: " . $e->getMessage());
        }
    }

    protected function getRanMigrations(){
        try {
            $stmt = $this->pdo->query("SELECT migration FROM msk_migrations");
            $ran = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            return $ran;
        } catch (\PDOException $e) {
            $this->logConsole("❌ Could not fetch migrations: " . $e->getMessage());
            return [];
        }
    }

    protected function logMigration($migration)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO msk_migrations (migration) VALUES (:migration)");
            $stmt->execute(['migration' => $migration]);
            $this->logConsole("📝 Logged migration: $migration");
        } catch (\PDOException $e) {
            $this->logConsole("❌ Failed to log migration $migration: " . $e->getMessage());
        }
    }

    protected function runPendingMigrations()
    {
        $ran = $this->getRanMigrations();
        $files = glob($this->migrationsPath . '/*.sql');

        if (empty($files)) {
            $this->logConsole("⚠️ No .sql migration files found in: {$this->migrationsPath}");
            return;
        }

        foreach ($files as $file) {
            $name = basename($file);

            if (in_array($name, $ran)) {
                continue;
            }

            try {
                $sql = file_get_contents($file);
                $this->pdo->exec($sql);
                $this->logMigration($name);
            } catch (\PDOException $e) {
                $this->logConsole("❌ Error running $name: " . $e->getMessage());
            }
        }
    }

    protected function logConsole($msg)
    {
        echo "<pre style='color:white;background:#111;padding:8px;margin:4px 0;border-left:4px solid white;'>$msg</pre>";
    }
    public function runPluginMigrations($pluginName)
    {
        $pluginMigrationsPath = __DIR__ . '/../app/plugins/' . $pluginName . '/migrations';

        if (!is_dir($pluginMigrationsPath)) {
            return;
        }

        $ran = $this->getRanMigrations();
        $files = glob($pluginMigrationsPath . '/*.sql');

        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            $name = basename($file);

            if (in_array($name, $ran)) {
                continue;
            }

            try {
                $sql = file_get_contents($file);
                $this->pdo->exec($sql);
                $this->logMigration($name);
            } catch (\PDOException $e) {
                $this->logConsole("❌ Error running $name: " . $e->getMessage());
            }
        }
    }
}

new Migrations();