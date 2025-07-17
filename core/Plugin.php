<?php

namespace Core;

abstract class Plugin
{
    /**
     * @var string The plugin's name
     */
    protected $name;

    /**
     * @var string The plugin's version
     */
    protected $version;

    /**
     * @var string The plugin's author
     */
    protected $author;

    /**
     * @var string The plugin's description
     */
    protected $description;

    public function __construct()
    {
        // Auto-load metadata from doc comment
        $meta = $this->readPluginMetadata();

        $this->name = $meta['Plugin Name'] ?? 'Unknown Plugin';
        $this->version = $meta['Version'] ?? '1.0';
        $this->author = $meta['Author'] ?? 'Unknown';
        $this->description = $meta['Description'] ?? 'No description available.';
    }

    /**
     * Reads plugin metadata from class docblock.
     *
     * @return array
     */
    protected function readPluginMetadata(): array
    {
        $reflection = new \ReflectionClass($this);
        $file = $reflection->getFileName();
        if (!file_exists($file)) return [];

        $content = file_get_contents($file);

        if (preg_match('/\/\*\*(.*?)\*\//s', $content, $matches)) {
            $block = $matches[1];
            $fields = ['Plugin Name', 'Version', 'Author', 'Description'];
            $meta = [];

            foreach ($fields as $field) {
                if (preg_match('/' . preg_quote($field) . ':\s*(.+)/', $block, $m)) {
                    $meta[$field] = trim($m[1]);
                }
            }

            return $meta;
        }

        return [];
    }

    /**
     * Get the plugin's name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the plugin's version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the plugin's author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get the plugin's description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Method to run when the plugin is activated
     */
    abstract public function activate();

    /**
     * Method to run when the plugin is deactivated
     */
    abstract public function deactivate();
}
