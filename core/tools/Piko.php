<?php
/**
 * Name: Piko
 * Version: 3.0
 * Author: Promise Peter Akpan
 * Description: Piko is a modern code quality, style checker, and formatter for your PHP projects.
 */

namespace Core\Tools;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

final class Piko
{
    private string $basePath;
    private array $violations = [];

    public function __construct()
    {
        $this->basePath = dirname(__DIR__, 2); // Project root
    }

    /**
     * ✅ Inspect the project and list all classes in a table
     */
    public function inspect(): string
    {
        $classes = [];
        $count = 0;
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->basePath));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                if (preg_match_all('/class\s+([a-zA-Z0-9_]+)/', $content, $matches)) {
                    foreach ($matches[1] as $className) {
                        $classes[] = [
                            'class' => $className,
                            'file' => str_replace($this->basePath, '', $file->getPathname())
                        ];
                        $count++;
                    }
                }
            }
        }

        $html = "<h2 style='color:#4f46e5;'>📊 Found {$count} Classes</h2>
                 <table style='width:100%;border-collapse:collapse;border:1px solid #ddd;'>
                    <thead style='background:#4f46e5;color:white;'>
                        <tr><th style='padding:8px;'>#</th><th style='padding:8px;'>Class</th><th style='padding:8px;'>File</th></tr>
                    </thead><tbody>";

        foreach ($classes as $i => $data) {
            $html .= "<tr>
                        <td style='padding:8px;border-bottom:1px solid #ddd;'>".($i+1)."</td>
                        <td style='padding:8px;border-bottom:1px solid #ddd;'>{$data['class']}</td>
                        <td style='padding:8px;border-bottom:1px solid #ddd;'>{$data['file']}</td>
                      </tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    }

    /**
     * ✅ Check PSR-12 style violations
     */
    public function checkStyle(): string
    {
        $files = $this->getPhpFiles();
        $this->violations = [];

        foreach ($files as $file) {
            $lines = file($file);
            foreach ($lines as $index => $line) {
                if (preg_match('/\t/', $line)) {
                    $this->violations[] = [
                        'file' => $file,
                        'line' => $index + 1,
                        'issue' => 'Tab used instead of spaces'
                    ];
                }
                if (preg_match('/\s+$/', $line)) {
                    $this->violations[] = [
                        'file' => $file,
                        'line' => $index + 1,
                        'issue' => 'Trailing whitespace'
                    ];
                }
            }
        }

        return $this->renderViolations();
    }

    /**
     * ✅ Fix PSR-12 violations + format PHP files
     */
    public function formatCode(): string
    {
        $files = $this->getPhpFiles();
        $fixedCount = 0;

        foreach ($files as $file) {
            $content = file_get_contents($file);

            // 1. Remove unnecessary top whitespace
            $content = preg_replace('/^\s+<\?php/', '<?php', $content);

            // 2. Replace tabs with 4 spaces
            $content = preg_replace('/\t/', '    ', $content);

            // 3. Remove trailing spaces
            $content = preg_replace('/\s+$/m', '', $content);

            // 4. Ensure a single newline at the end of file
            $content = rtrim($content) . "\n";

            // 5. Add space after control structures
            $content = preg_replace('/\b(if|else|elseif|for|foreach|while|switch)\(/', '$1 (', $content);

            // 6. Normalize opening braces
            $content = preg_replace('/\)\s*\{/', ') {', $content);

            // 7. Remove multiple empty lines (keep max 2)
            $content = preg_replace("/\n{3,}/", "\n\n", $content);

            if ($content !== file_get_contents($file)) {
                file_put_contents($file, $content);
                $fixedCount++;
            }
        }

        return "<p style='color:green;font-weight:bold;'>✅ Formatted {$fixedCount} file(s) successfully!</p>";
    }

    /**
     * ✅ NEW: Reorder class methods (Public → Protected → Private)
     */
    public function reorderClassMethods(): string
    {
        $files = $this->getPhpFiles();
        $rewritten = 0;

        foreach ($files as $file) {
            $content = file_get_contents($file);

            if (preg_match('/class\s+\w+\s*[^{]*\{([\s\S]*)\}$/', $content, $matches)) {
                $classBody = $matches[1];

                // Extract methods
                preg_match_all('/(\/\*\*[\s\S]*?\*\/\s*)?(public|protected|private)\s+function\s+\w+\s*\([^\)]*\)\s*\{[\s\S]*?\}/', $classBody, $methodMatches, PREG_SET_ORDER);

                $publicMethods = [];
                $protectedMethods = [];
                $privateMethods = [];

                foreach ($methodMatches as $m) {
                    $doc = $m[1] ?? '';
                    $visibility = $m[2];
                    $methodCode = $m[0];

                    if ($visibility === 'public') {
                        $publicMethods[] = $doc . $methodCode;
                    } elseif ($visibility === 'protected') {
                        $protectedMethods[] = $doc . $methodCode;
                    } else {
                        $privateMethods[] = $doc . $methodCode;
                    }
                }

                // Remove old methods
                $newClassBody = preg_replace('/(\/\*\*[\s\S]*?\*\/\s*)?(public|protected|private)\s+function\s+\w+\s*\([^\)]*\)\s*\{[\s\S]*?\}/', '', $classBody);
                $newClassBody = preg_replace("/\n{3,}/", "\n\n", trim($newClassBody));

                // Rebuild class body
                $reordered = $newClassBody . "\n\n" .
                             implode("\n\n", $publicMethods) . "\n\n" .
                             implode("\n\n", $protectedMethods) . "\n\n" .
                             implode("\n\n", $privateMethods);

                $newContent = preg_replace('/(class\s+\w+\s*[^{]*\{)[\s\S]*(\})$/', '$1' . "\n" . $reordered . "\n" . '$2', $content);

                if ($newContent !== $content) {
                    file_put_contents($file, $newContent);
                    $rewritten++;
                }
            }
        }

        return "<p style='color:blue;font-weight:bold;'>✅ Reordered methods in {$rewritten} class file(s).</p>";
    }

    /**
     * ✅ Get all PHP files recursively
     */
    private function getPhpFiles(): array
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->basePath));
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        return $files;
    }

    /**
     * ✅ Render style violations in a clean table
     */
    private function renderViolations(): string
    {
        if (empty($this->violations)) {
            return "<p style='color:green;font-weight:bold;'>✅ No style violations found. Everything looks great!</p>";
        }

        $html = "<h3 style='color:#b91c1c;'>❌ Style Violations Detected</h3>
                 <table style='width:100%;border-collapse:collapse;border:1px solid #ddd;'>
                    <thead style='background:#b91c1c;color:white;'>
                        <tr><th style='padding:8px;'>File</th><th style='padding:8px;'>Line</th><th style='padding:8px;'>Issue</th></tr>
                    </thead><tbody>";

        foreach ($this->violations as $v) {
            $html .= "<tr>
                        <td style='padding:8px;border-bottom:1px solid #ddd;'>{$v['file']}</td>
                        <td style='padding:8px;border-bottom:1px solid #ddd;'>{$v['line']}</td>
                        <td style='padding:8px;border-bottom:1px solid #ddd;'>{$v['issue']}</td>
                      </tr>";
        }

        $html .= "</tbody></table>";
        return $html;
    }
}