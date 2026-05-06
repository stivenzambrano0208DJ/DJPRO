<?php
/**
 * DJ Platform Entry Point
 */

// Start Session with persistence
if (session_status() === PHP_SESSION_NONE) {
    // 30 days in seconds
    $lifetime = 30 * 24 * 60 * 60; 
    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path' => '/',
        'domain' => '',
        'secure' => false, // Cambiar a true si se usa HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    ini_set('session.gc_maxlifetime', $lifetime);
    session_start();
}

// Load Configuration
require_once '../config/config.php';
require_once '../config/database.php';

// Autoload Core Classes
spl_autoload_register(function ($class) {
    $path = '../app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Initialize Router
$router = new Core\Router();

