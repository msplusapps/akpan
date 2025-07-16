<?php
namespace Core;

class Migrations extends Database
{
    protected $migrationsPath = __DIR__ . '/../app/migrations';

    public function __construct() {
        parent::__construct(); // Connect DB

        if (!$this->pdo) {
            $this->logConsole("❌ PDO not available. Aborting migration.");
            return;
        }

        $this->createMigrationsTable();
        $this->runPendingMigrations();
    }

    protected function createMigrationsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS akn_migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            performed_by VARCHAR(255) DEFAULT 'system',
            migration VARCHAR(255) UNIQUE,
            migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            $this->logConsole("❌ Failed to create migrations table: " . $e->getMessage());
        }
    }

    protected function getRanMigrations() {
        try {
            $stmt = $this->pdo->query("SELECT migration FROM akn_migrations");
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOException $e) {
            $this->logConsole("❌ Could not fetch migrations: " . $e->getMessage());
            return [];
        }
    }

    protected function logMigration($migration, $performedBy = 'system') {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO akn_migrations (performed_by, migration) VALUES (:performed_by, :migration)");
            $stmt->execute([
                'performed_by' => $performedBy,
                'migration' => $migration
            ]);
            $this->logConsole("📝 Logged migration: $migration by $performedBy");
        } catch (\PDOException $e) {
            $this->logConsole("❌ Failed to log migration $migration: " . $e->getMessage());
        }
    }

    protected function runPendingMigrations() {
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
                $this->logMigration($name); // system migration
            } catch (\PDOException $e) {
                $this->logConsole("❌ Error running $name: " . $e->getMessage());
            }
        }
    }

    public function runPluginMigrations($pluginName) {
        $pluginMigrationsPath = base_path('/app/plugins/') . $pluginName . '/migrations';

        if (!is_dir($pluginMigrationsPath)) {
            return;
        }

        $ran = $this->getRanMigrations();
        $files = glob($pluginMigrationsPath . '/*.sql');

        if (empty($files)) {
            $this->logConsole("⚠️ No migration files found for plugin: $pluginName");
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
                $this->logMigration($name, $pluginName); // plugin-specific
            } catch (\PDOException $e) {
                $this->logConsole("❌ Error running plugin migration $name: " . $e->getMessage());
            }
        }
    }

    protected function logConsole($msg) {
        echo "<pre style='color:white;background:#111;padding:8px;margin:4px 0;border-left:4px solid white;'>$msg</pre>";
    }
}
