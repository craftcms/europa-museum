<?php
/**
 * Shared bootstrap file
 */

// Set the error reporting level
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Define path constants
define('CRAFT_BASE_PATH', __DIR__);
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH . '/vendor');

// Load Composer's autoloader
require_once CRAFT_VENDOR_PATH . '/autoload.php';

// Load dotenv?
if (class_exists(Dotenv\Dotenv::class)) {
    // Use `createMutable` to allow .env file overrides for existing environment variables.
    Dotenv\Dotenv::createImmutable(CRAFT_BASE_PATH)->safeLoad();
}
