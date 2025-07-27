<?php

namespace App\Plugins\Zapper\Controllers;
use App\Plugins\Zapper\Models\Zapper;
use Core\Controller;
use Core\Cors;
use Core\Utils\FileManager;
class ZapperController extends Controller{
    private $basePath;
    public  function __construct() {
        $this->basePath = base_path("storage/plugins/zapper/");
    }
    public function index() {
        $zapper = new Zapper();
        $zapper->wipe();
        $this->view("Zapper@index", [
            "title" => "Zapper App"
        ]);
    }
    public function send() {
        $zapper = new Zapper();
        $zapper->updateById(1, ['status'=>'connected']);
        $this->view("Zapper@send",[
            "title"=>"Zapper File Transfer",
            "device_id"=>$_GET['deviceId']
        ]);
    }
    public function api() {
        $cors = new Cors(
            allowedOrigins: ['http://localhost', 'http://192.168.50.56'],
            allowedMethods: ['GET', 'POST', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization']
        );
        $cors->handle();
        // Handle preflight request for CORS
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
        // Only allow POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Only GET requests allowed']);
            exit;
        }
        $deviceId = $_GET['deviceId'] ?? null;
        if (!$deviceId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing deviceId']);
            exit;
        }
        // Example insert (uncomment in real case)
        $zapper = new Zapper();
        $zapper->create(['device_info' => $deviceId]);
        http_response_code(200);
        echo json_encode(['message' => 'Device registered. Stop listening']);
    }
    public function handshake() {
        $zapper = new Zapper();
        $response = $zapper->findById(1);
        FileManager::deleteDirectory($this->basePath);
        if ($response['status'] == 'connected') {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }
    public function files() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Only POST method is allowed']);
            exit;
        }
        if (!isset($_FILES['file'])) {
            http_response_code(400);
            echo json_encode(['error' => 'File not received']);
            exit;
        }
        $file = $_FILES['file'];
        $originalName = $file['name'];
        $tmpName = $file['tmp_name'];
        $error = $file['error'];
        if ($error !== UPLOAD_ERR_OK) {
            http_response_code(500);
            echo json_encode(['error' => 'Upload failed with code: ' . $error]);
            exit;
        }
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $randomName = substr(md5(mt_rand()), 0, 6); // 6 chars max
        $newFileName = $randomName . '.' . $ext;
        $uploadDir = $this->basePath;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $destination = $uploadDir . $newFileName;
        if (!move_uploaded_file($tmpName, $destination)) {
            http_response_code(500);
            echo json_encode(['error' => 'Could not move uploaded file']);
            exit;
        }
        echo json_encode([
            'status' => 'ok',
            'message' => 'Upload successful',
            'filename' => $newFileName,
            'path' => 'storage/plugins/zapper/' . $newFileName
        ]);
    }
    function monitor() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        $storagePath = $this->basePath;
        if (!is_dir($storagePath)) {
            echo json_encode(['status' => 'error', 'message' => 'Storage folder not found.']);
            return;
        }
        $files = scandir($storagePath);
        $fileGroups = [
            'Images' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'],
            'Videos' => ['mp4', 'avi', 'mov', 'mkv'],
            'Documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
            'Others' => []
        ];
        $groupedFiles = [
            'Images' => [],
            'Videos' => [],
            'Documents' => [],
            'Others' => []
        ];
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $fullPath = $storagePath . $file;
            if (!is_file($fullPath)) continue;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $type = 'Others';
            foreach ($fileGroups as $group => $extensions) {
                if (in_array($ext, $extensions)) {
                    $type = $group;
                    break;
                }
            }
            $groupedFiles[$type][] = [
                'name' => $file,
                'url' => 'storage/plugins/zapper/' . $file,
                'size' => filesize($fullPath),
                'modified' => date("Y-m-d H:i:s", filemtime($fullPath)),
                'extension' => $ext,
            ];
        }
        echo json_encode([
            'status' => 'success',
            'data' => $groupedFiles
        ]);
    }
    public function delete() {
        // Make sure it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Invalid request method']);
            return;
        }
        // Get file path from POST request
        $filename = $_POST['path'] ?? null;
        if (!$filename) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing file parameter']);
            return;
        }
        $zapper = new Zapper();
        $response = $zapper->findById(1);
        // Ensure the file exists before attempting deletion
        $fullPath = $this->basePath."".$filename;
        if (!file_exists($fullPath)) {
            http_response_code(404);
            echo json_encode(['error' => 'File not found']);
            return;
        }
        // Delete the specific file
        if (unlink($fullPath)) {
            if ($response['status'] === 'connected') {
                http_response_code(200);
                echo json_encode(['message' => 'File deleted successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Zapper not connected']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete file']);
        }
    }
    public function mobileTransfer() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Only POST method is allowed']);
            exit;
        }
        if (!isset($_FILES['file'])) {
            http_response_code(400);
            echo json_encode(['error' => 'File not received']);
            exit;
        }
        $file = $_FILES['file'];
        $originalName = $file['name'];
        $tmpName = $file['tmp_name'];
        $error = $file['error'];
        if ($error !== UPLOAD_ERR_OK) {
            http_response_code(500);
            echo json_encode(['error' => 'Upload failed with code: ' . $error]);
            exit;
        }
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $randomName = substr(md5(mt_rand()), 0, 6); // 6 chars max
        $newFileName = $randomName . '.' . $ext;
        $uploadDir = getenv('HOME') . "/Documents/zapper";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $destination = $uploadDir . $newFileName;
        if (!move_uploaded_file($tmpName, $destination)) {
            http_response_code(500);
            echo json_encode(['error' => 'Could not move uploaded file']);
            exit;
        }
        echo json_encode([
            'status' => 'ok',
            'message' => 'Mobile file upload successful',
            'originalName' => $originalName,
            'filename' => $newFileName,
            'path' => 'storage/plugins/zapper/' . $newFileName
        ]);
    }
}
