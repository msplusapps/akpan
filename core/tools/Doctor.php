<?php

/**
 * Name: Doctor
 * Version: 1.1
 * Author: Promise Peter Akpan
 * Description: This is an MVC management tool that helps to keep everything in order.
 */
namespace Core\tools;
use ReflectionClass;
use ReflectionMethod;
final class Doctor
{
    private string $output = '';
    private string $className;
    private ?ReflectionClass $reflection = null;
    public function __construct() {
        $this->output = '';
    }
    public function greet(): self {
        echo $this->output .= "🩺 Welcome, I am your code doctor.\n";
        return $this;
    }
    public function inspect() {
        $basePath = dirname(__DIR__, 2); // Project root
        $classes = [];
        $classCount = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath)
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                if (preg_match_all('/class\s+([a-zA-Z0-9_]+)/', $content, $matches)) {
                    foreach ($matches[1] as $className) {
                        $classes[] = [
                            'class' => $className,
                            'file' => str_replace($basePath, '', $file->getPathname())
                        ];
                        $classCount++;
                    }
                }
            }
        }
        return [
            'total_classes' => $classCount,
            'classes_found' => $classes
        ];
    }
    public function checkConstructor(): self {
        if (!$this->reflection) return $this;
        $constructor = $this->reflection->getConstructor();
        $this->output .= $constructor
            ? "✅ Constructor found.\n"
            : "⚠️ No constructor found.\n";
        return $this;
    }
    public function checkNamingConvention(): self {
        if (!$this->reflection) return $this;
        $shortName = $this->reflection->getShortName();
        if (!preg_match('/^[A-Z][A-Za-z0-9]*$/', $shortName)) {
            $this->output .= "⚠️ Class name '$shortName' doesn't follow PascalCase.\n";
        } else {
            $this->output .= "✅ Naming convention (PascalCase) is correct.\n";
        }
        return $this;
    }
    public function checkClassType(): self {
        if (!$this->reflection) return $this;
        if ($this->reflection->isAbstract()) {
            $this->output .= "🧱 This is an abstract class.\n";
        } elseif ($this->reflection->isFinal()) {
            $this->output .= "🔐 This is a final class.\n";
        } else {
            $this->output .= "📦 This is a regular class.\n";
        }
        return $this;
    }
    public function checkInheritance(): self {
        if (!$this->reflection) return $this;
        $parent = $this->reflection->getParentClass();
        $this->output .= $parent
            ? "🧬 Inherits from: " . $parent->getName() . "\n"
            : "🧬 No inheritance found.\n";
        return $this;
    }
    public function checkInterfaces(): self {
        if (!$this->reflection) return $this;
        $interfaces = $this->reflection->getInterfaceNames();
        if (count($interfaces) > 0) {
            $this->output .= "🔗 Implements interfaces: " . implode(', ', $interfaces) . "\n";
        } else {
            $this->output .= "🔗 No interfaces implemented.\n";
        }
        return $this;
    }
    public function checkMethods(): self {
        if (!$this->reflection) return $this;
        $methods = $this->reflection->getMethods();
        foreach ($methods as $method) {
            $visibility = $method->isPublic() ? 'public' : ($method->isProtected() ? 'protected' : 'private');
            $this->output .= "🔧 Method: {$method->getName()} ({$visibility})\n";
        }
        return $this;
    }
    public function typoScan(): self {
        if (!$this->reflection) return $this;
        $methods = $this->reflection->getMethods();
        foreach ($methods as $method) {
            if (preg_match('/[A-Z]{3,}/', $method->getName())) {
                $this->output .= "⚠️ Possible typo in method name: {$method->getName()}\n";
            }
        }
        return $this;
    }
    public function result(): string {
        return $this->output;
    }
}
