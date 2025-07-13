<?php
session_start();

// Load environment variables
require __DIR__ . "/Env.php";

// Error handler and utility functions
require __DIR__ . "/ErrorHandler.php";
require __DIR__ . "/functions.php";

// Core database and base model
require __DIR__ . "/Database.php";     // ✅ Add this line
require __DIR__ . "/Model.php";

// Base controller
require __DIR__ . "/Controller.php";

// Router
require __DIR__ . "/Router.php";

// Auto-run migrations (non-blocking)
require_once __DIR__ . '/Migrations.php';
