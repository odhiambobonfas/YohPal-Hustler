<?php

/**
 * Entry point for the YohPal Hustler Application
 * 
 * Responsibilities include;
 * - Initialize system configurations
 * - Load necessary application settings
 * - Bootstrap the app (connect to database, load environment variables, etc.)
 * - Route incoming requests to appropriate handlers (controllers/views)
 */

// Include the main application configuration file
// This file sets up environment settings, autoloaders, error handlers, etc.
include_once __DIR__ . "/utils/config/index.php";
