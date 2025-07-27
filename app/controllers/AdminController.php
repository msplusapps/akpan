<?php
namespace App\Controllers;
use Core\Controller;
use App\Models\User;
use Core\PluginTemplateGenerator;
use Core\Router;
use Core\tools\Doctor;
use Core\Utils\FileManager;
use Core\Utils\PluginTemplateGenerator as UtilsPluginTemplateGenerator;
class AdminController extends Controller
{
    public function __construct() {
        // Require authentication
        if (empty($_SESSION['user'])) {
            redirect('./auth/login');
        }
    }
    public function index() {
        return $this->view('admin/index', [
            'title' => 'Admin Dashboard'
        ]);
    }
    public function docs() {
        return $this->view('admin/docs', [
            'title' => 'Admin Dashboard'
        ]);
    }
    public function plugins() {
        return $this->view('admin/plugins', [
            'title' => 'Admin Dashboard'
        ]);
    }
    public function newPlugins() {
        return $this->view('admin/plugins.new', [
            'title' => 'Create New Plugin'
        ]);
    }
    public function routes() {
        $routes = \Core\Router::getRoutes();
        return $this->view('admin/routes', [
            'title' => 'Admin Dashboard',
            'routes' => $routes
        ]);
    }
    public function middlewares() {
        return $this->view('admin/middlewares', [
            'title' => 'Admin middlewares'
        ]);
    }
    public function migrations() {
        return $this->view('admin/migrations', [
            'title' => 'Admin migrations'
        ]);
    }
    public function controllers() {
        $routes = Router::getRoutes();
        return $this->view('admin/controllers', [
            'title' => 'Registered Controllers',
            'routes' => $routes
        ]);
    }
    public function users() {
        $userModel = new User();
        $users = $userModel->all();
        return $this->view('admin/users', [
            'title' => 'Registered Users',
            'users' => $users
        ]);
    }
    public function assets() {
        return $this->view('admin/assets', [
            'title' => 'Registered Assets'
        ]);
    }
    public function delete_user($id) {
        $userModel = new User();
        $userModel->delete($id);
        redirect('admin/users');
    }
    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        redirect('./auth/login');
    }
    public function cache() {
        return $this->view('admin/cache');
    }
    public function tools() {
        return $this->view('admin/tools');
    }
    public function piko() {
        return $this->view('admin/piko');
    }
    public function pikoRun($method) {
        $tool = 'Piko'; // e.g., piko → Piko
        $method = trim($method);
        $toolClass = "\\Core\\Tools\\{$tool}";
        if (!class_exists($toolClass)) {
            return $this->renderError("❌ Tool '{$tool}' not found.");
        }
        $instance = new $toolClass();
        if (!method_exists($instance, $method)) {
            return $this->renderError("❌ Method '{$method}' not found in {$tool}.");
        }
        // Execute the method and capture the output
        $result = call_user_func([$instance, $method]);
        // If result is array or object, format it for display
        if (is_array($result) || is_object($result)) {
            $result = $this->formatArrayToTable((array)$result);
        }
        echo $this->renderUI($tool, $method, $result);
    }
    /**
     * Render a nice error box
     */
    private function renderError($message) {
        return "<div class='bg-red-100 text-red-800 p-4 rounded-lg shadow'>$message</div>";
    }
    /**
     * Convert array to a beautiful table
     */
    private function formatArrayToTable(array $data) {
        $html = "<table class='min-w-full border border-gray-300 mt-4'>";
        foreach ($data as $key => $value) {
            $html .= "<tr class='border-b'>
                        <td class='p-2 font-bold bg-gray-100 w-1/4'>" . htmlspecialchars($key) . "</td>
                        <td class='p-2'>" . htmlspecialchars(is_array($value) ? json_encode($value) : $value) . "</td>
                    </tr>";
        }
        $html .= "</table>";
        return $html;
    }
    /**
     * Wrap result in a nice UI
     */
    private function renderUI($tool, $method, $result) {
        return "
        <section class='max-w-5xl mx-auto px-6 py-12'>
            <h2 class='text-3xl font-bold text-indigo-800 mb-6'>Running {$tool}::{$method}()</h2>
            <div class='bg-white rounded-xl shadow p-6'>
                {$result}
            </div>
            <a href='" . url('admin/tools') . "' class='mt-6 inline-block text-indigo-600 hover:underline'>← Back to Tools</a>
        </section>";
    }
    public function run($method) {
        $doctor = new Doctor;
        if (method_exists($doctor, $method)) {
            $result = call_user_func([$doctor, $method]);
            echo "<div class='p-6 bg-gray-50 min-h-screen font-sans'>";
            echo "<h1 class='text-3xl font-bold mb-6 text-indigo-700'>Doctor → {$method}()</h1>";
            if (is_array($result) && isset($result['classes_found'])) {
                echo "<div class='bg-white rounded-xl shadow-lg p-6'>";
                echo "<h2 class='text-xl font-semibold text-gray-800 mb-4'>
                        Total Classes Found:
                        <span class='text-indigo-600 font-bold'>{$result['total_classes']}</span>
                    </h2>";
                echo "<div class='overflow-x-auto'>";
                echo "<table class='min-w-full bg-white border border-gray-200 rounded-lg'>";
                echo "<thead class='bg-indigo-600 text-white'>";
                echo "<tr>
                        <th class='text-left py-3 px-4'>#</th>
                        <th class='text-left py-3 px-4'>Class Name</th>
                        <th class='text-left py-3 px-4'>File Path</th>
                    </tr>";
                echo "</thead>";
                echo "<tbody class='divide-y divide-gray-200'>";
                foreach ($result['classes_found'] as $index => $classData) {
                    echo "<tr class='hover:bg-indigo-50 transition'>";
                    echo "<td class='py-3 px-4 text-gray-700'>" . ($index + 1) . "</td>";
                    echo "<td class='py-3 px-4 font-mono text-indigo-700'>" . htmlspecialchars($classData['class']) . "</td>";
                    echo "<td class='py-3 px-4 text-gray-600 text-sm'>" . htmlspecialchars($classData['file']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>"; // overflow-x-auto
                echo "</div>"; // bg-white card
            } else {
                echo "<div class='bg-green-100 text-green-700 p-4 rounded-lg shadow'>{$result}</div>";
            }
            echo "</div>";
            return;
        }
        echo "<div class='bg-red-100 text-red-700 p-4 rounded-lg shadow'>❌ Method '{$method}' not found in Doctor class.</div>";
    }
    
    public function doctor() {
        $className = Doctor::class;
        // Get all public methods defined in the Doctor class, excluding inherited ones
        $methods = array_filter(
            get_class_methods($className),
            function ($method) use ($className) {
                $reflector = new \ReflectionMethod($className, $method);
                return $reflector->isPublic() && $reflector->getDeclaringClass()->getName() === $className;
            }
        );
        return $this->view('admin/doctor', ['methods' => $methods]);
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
        $viewFolder = "$basePath/views";
        FileManager::createDirectory($viewFolder);
        $viewContent = UtilsPluginTemplateGenerator::generateViewTemplate($plugin);
        FileManager::createFile("$viewFolder/index.view.php", $viewContent);
        redirect("../../admin/plugins");
    }
    function deletePlugin() {
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
}
