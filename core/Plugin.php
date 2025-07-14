<?php

namespace Core;

abstract class Plugin {

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

    public function __construct() {
        // Default constructor
    }

    /**
     * Get the plugin's name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the plugin's version
     *
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Get the plugin's author
     *
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Get the plugin's description
     *
     * @return string
     */
    public function getDescription() {
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
