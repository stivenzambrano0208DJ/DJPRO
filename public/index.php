<?php
/**
 * DJ Platform Entry Point
 */

// Start Session with secure defaults
if (session_status() === PHP_SESSION_NONE) {
    $lifetime = 2 * 60 * 60;
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path' => '/',
        'domain' => '',
        'secure' => $isHttps,
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
