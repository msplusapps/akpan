<?php
if (!function_exists('env')) {
        function env($key, $default = null) {
            static $vars = null;
            if ($vars === null) {
                $envPath = base_path('.env'); // adjust path if needed
                if (!file_exists($envPath)) {
                    throw new Exception(".env file not found at $envPath");
                }
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $vars = [];
                foreach ($lines as $line) {
                    if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
                        continue;
                    }
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value, " \t\n\r\0\x0B\"'");
                    $vars[$name] = $value;
                    putenv("$name=$value"); // optional
                }
            }
            return $vars[$key] ?? $default;
        }
    }
    function read_plugin_metadata($file) {
        $content = file_get_contents($file);
        if (preg_match('/\/\*\*(.*?)\*\//s', $content, $matches)) {
            $block = $matches[1];
            $fields = [
                'Name' => '',
                'Version' => '',
                'Author' => '',
                'Description' => ''
            ];
            foreach ($fields as $key => &$value) {
                if (preg_match('/' . preg_quote($key) . ':\s*(.+)/', $block, $match)) {
                    $value = trim($match[1]);
                }
            }
            return [
                'name' => $fields['Name'],
                'version' => $fields['Version'],
                'author' => $fields['Author'],
                'description' => $fields['Description']
            ];
        }
        return null;
    }
    function getInnerHTML(\DOMNode $node): string {
        $innerHTML = '';
        foreach ($node->childNodes as $child) {
            $innerHTML .= $node->ownerDocument->saveHTML($child);
        }
        return $innerHTML;
    }
    // $home = getenv('USERPROFILE') ?: getenv('HOME');
    // Check if we got a valid home path
    // if ($home) {
    //     // Build path to the Documents folder
    //     $documentsFolder = $home . DIRECTORY_SEPARATOR . 'Documents';
    //     // Output the Documents folder path
    //     echo "User Documents Folder: " . $documentsFolder;
    // } else {
    //     echo "Unable to detect user home directory.";
    // }
