<?php
namespace App\Controllers;
use Core\Controller;
use App\Models\User;
use Core\PluginTemplateGenerator;
use Core\Utils\FileManager;
use Core\Utils\PluginTemplateGenerator as UtilsPluginTemplateGenerator;

class AdminController extends Controller
{
    public function __construct()
    {
        // Require authentication
        if (empty($_SESSION['user'])) {
            redirect('./auth/login');
        }
    }

    public function index()
    {
        return $this->view('admin/index', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function docs()
    {
        return $this->view('admin/docs', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function plugins()
    {
        return $this->view('admin/plugins', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function newPlugins()
    {
        return $this->view('admin/plugins.new', [
            'title' => 'Create New Plugin'
        ]);
    }



    public function routes()
    {
        $routes = \Core\Router::all();
        return $this->view('admin/routes', [
            'title' => 'Admin Dashboard',
            'routes' => $routes
        ]);
    }

    public function controllers()
    {
        $routes = \Core\Router::all();
        return $this->view('admin/controllers', [
            'title' => 'Registered Controllers',
            'routes' => $routes
        ]);
    }

    public function users()
    {
        $userModel = new User();
        $users = $userModel->all();

        return $this->view('admin/users', [
            'users' => $users
        ]);
    }

    public function delete_user($id)
    {
        $userModel = new User();
        $userModel->delete($id);

        redirect('admin/users');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        redirect('./auth/login');
    }

    public function cache()
    {
        return $this->view('admin/cache');
    }

    public function updateCache()
    {
        if (isset($_POST['cache_enabled'])) {
            Core\Utils\Cache::enable();
        } else {
            Core\Utils\Cache::disable();
        }
        redirect('admin/cache');
    }

   public function createNewPlugin() {
        $pluginName = $_POST['name'] ?? null;
        $pluginAuthor = $_POST['author'] ?? null;
        $pluginVersion = $_POST['version'] ?? null;
        $pluginDescription = $_POST['description'] ?? null;

        if (!$pluginName) {
            echo "Plugin name not provided.";
            return;
        }

        $className = ucfirst($pluginName);
        $basePath = "app/Plugins/$className";

        // Create plugin base folders
        FileManager::createDirectory($basePath);
        FileManager::createDirectory("$basePath/migrations");
        FileManager::createDirectory("$basePath/controllers");
        FileManager::createDirectory("$basePath/models");
        FileManager::createDirectory("$basePath/views");

        // Plugin object
        $plugin = (object)[
            'plugin_name' => $pluginName,
            'version' => $pluginVersion ?? '1.0',
            'author' => $pluginAuthor ?? 'System',
            'description' => $pluginDescription ?? ''
        ];

        // ✅ Generate main plugin class
        $template = UtilsPluginTemplateGenerator::generate($plugin);
        $mainFile = "$basePath/{$className}.php";
        if (!FileManager::createFile($mainFile, $template)) {
            echo "Failed to create plugin file.";
            return;
        }

        // ✅ Generate Controller
        $controllerContent = UtilsPluginTemplateGenerator::generateController($plugin);
        FileManager::createFile("$basePath/controllers/{$className}Controller.php", $controllerContent);

        // ✅ Generate Migration SQL
        $migrationContent = UtilsPluginTemplateGenerator::generateMigration($plugin);
        $migrationFile = "$basePath/migrations/create_" . strtolower($plugin->plugin_name) . "_table.sql";
        FileManager::createFile($migrationFile, $migrationContent);

        // ✅ Generate Model
        $modelContent = UtilsPluginTemplateGenerator::generateModelTemplate($plugin);
        FileManager::createFile("$basePath/models/{$className}.php", $modelContent);

        // ✅ Generate View Folder and Default View File
        $viewFolder = "$basePath/views/{$pluginName}";
        FileManager::createDirectory($viewFolder);

        $viewContent = UtilsPluginTemplateGenerator::generateViewTemplate($plugin);
        FileManager::createFile("$viewFolder/index.php", $viewContent);

        redirect("../../admin/plugins");
    }

    function deletePlugin(){
        $pluginName = isset($_GET['plugin']) ? urldecode(trim($_GET['plugin'])) : '';

        if (!$pluginName) {
            die("Invalid plugin name.");
        }

        $pluginName = preg_replace('/\s+/', '', $pluginName);         // Remove all whitespace
        $pluginName = preg_replace('/plugin/i', '', $pluginName);     // Remove the word "Plugin", case-insensitive

        if (!$pluginName) {
            die("Invalid or empty plugin name after cleanup.");
        }

        $pluginFolder = str_replace(' ', '', $pluginName); // e.g., 'clap Plugin' -> 'clapPlugin'
        $pluginFolder = preg_replace('/[^a-zA-Z0-9]/', '', $pluginFolder); // sanitize

        echo $fullPath = plugins_path($pluginFolder);

        if (!is_dir($fullPath)) {
            return false;
        }
        FileManager::deleteDirectory($fullPath);
        redirect("../../admin/plugins");
    }


    public function clearCache()
    {
        Core\Utils\Cache::clear();
        redirect('admin/cache');
    }
}
