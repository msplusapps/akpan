<?php
namespace Core\Utils;
class PluginTemplateGenerator
{
    public static function generate($plugin): string
    {
        $className = ucfirst($plugin->plugin_name);
        $routeName = strtolower($plugin->plugin_name);
        return <<<PHP
<?php
/**
 * Plugin Name: {$plugin->plugin_name} Plugin
 * Version: {$plugin->version}
 * Author: {$plugin->author}
 * Description: {$plugin->description}
 */
namespace App\Plugins\\$className;
use Core\Plugin;
use Core\Router;
use App\Plugins\\$className\Controllers\\{$className}Controller;

class $className extends Plugin
{
    public function activate() {
        // Code to run when the plugin is activated
    }
    public function deactivate() {
        // Code to run when the plugin is deactivated
    }
    public function register() {
        Router::get('{$routeName}/', [{$className}Controller::class, 'index']); // GET /{$plugin->plugin_name}
    }
}
PHP;
    }
    public static function generateController($plugin): string {
        $className = ucfirst($plugin->plugin_name) . "Controller";
        return <<<PHP
<?php
namespace App\Plugins\\{$plugin->plugin_name}\Controllers;
use Core\Controller;
class $className extends Controller
{
    public function index() {
        \$this->view("{$plugin->plugin_name}@index");
    }
}
PHP;
    }
   public static function generateMigration(object $plugin): string
{
    $tableName = 'akn_' . strtolower($plugin->plugin_name);
    return <<<SQL
CREATE TABLE IF NOT EXISTS `{$tableName}` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
}
    public static function generateModelTemplate(object $plugin): string
{
    $className = ucfirst($plugin->plugin_name);
    $tableName = 'akn_' . strtolower($plugin->plugin_name);
    return <<<PHP
<?php
namespace App\Plugins\\{$className}\Models;
use Core\Model;
class {$className} extends Model
{
    protected \$table = '{$tableName}';
    public int \$id;
    public string \$created_at;
    public string \$updated_at;
    /**
     * Get all records
     */
    public static function all(): array
    {
        return \$this->select("SELECT * FROM " . \$this->prefix . static::\$table);
    }
    /**
     * Find a record by ID
     */
    public static function find(int \$id): ?array
    {
        \$result = \$this->select(
            "SELECT * FROM " . \$this->prefix . static::\$table . " WHERE id = :id LIMIT 1",
            ['id' => \$id]
        );
        return \$result[0] ?? null;
    }
    /**
     * Create a new record
     */
    public static function create(array \$data): bool
    {
        return \$this->insert(\$data);
    }
    /**
     * Update an existing record
     */
    public static function updateRecord(int \$id, array \$data): bool
    {
        return \$this->update(\$id, \$data);
    }
    /**
     * Delete a record by ID
     */
    public static function remove(int \$id): bool
    {
        return \$this->delete(\$id);
    }
}
PHP;
}
public static function generateViewTemplate(object $plugin): string
{
    $title = ucfirst($plugin->plugin_name) . " List";
    return <<<HTML
<h1>{$title}</h1>
<p>This is the default view for the {$plugin->plugin_name} plugin.</p>
<!-- You can loop through your data and display them here -->
<!-- Example:
<?php
foreach (\$data as \$item): ?>
    <div><?php
echo \$item['id']; ?></div>
<?php
endforeach; ?>
-->
HTML;
}
}
