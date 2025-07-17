<?php
namespace Core\Utils;

class FileManager {
    // Create a new file with optional content
    public static function createFile($filePath, $content = '') {
        if (file_put_contents($filePath, $content) !== false) {
            return "File created: $filePath";
        }
        return "Failed to create file: $filePath";
    }

    // Read a file's contents
    public static function readFile($filePath)
    {
        if (!file_exists($filePath)) {
            return "File does not exist: $filePath";
        }
        return file_get_contents($filePath);
    }

    // Create a new directory
    public static function createDirectory($dirPath)
    {
        if (!is_dir($dirPath)) {
            if (mkdir($dirPath, 0777, true)) {
                return "Directory created: $dirPath";
            }
            return "Failed to create directory: $dirPath";
        }
        return "Directory already exists: $dirPath";
    }

    // Read all files and directories inside a directory
    public static function readDirectory($dirPath)
    {
        if (!is_dir($dirPath)) {
            return "Directory does not exist: $dirPath";
        }

        $contents = scandir($dirPath);
        return array_diff($contents, ['.', '..']);
    }

    // Delete a file
    public static function deleteFile($filePath)
    {
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return "File deleted: $filePath";
            }
            return "Failed to delete file: $filePath";
        }
        return "File does not exist: $filePath";
    }

    // Delete an empty directory
    public static function deleteDirectory(string $dirPath): string {
        if (!is_dir($dirPath)) {
            return "Directory does not exist: $dirPath";
        }

        $items = scandir($dirPath);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $itemPath = $dirPath . DIRECTORY_SEPARATOR . $item;

            if (is_dir($itemPath)) {
                self::deleteDirectory($itemPath); // Recursively delete subdirectory
            } else {
                unlink($itemPath); // Delete file
            }
        }

        if (rmdir($dirPath)) {
            return "Directory deleted: $dirPath";
        } else {
            return "Failed to delete directory: $dirPath";
        }
    }

}


// echo N::createDirectory('core/cache');
// echo N::createFile('core/cache/hello.txt', 'Hello world');
// echo N::readFile('core/cache/hello.txt');
// print_r(N::deleteDirectory('test_folder'));