<?php
/**
 * Application Configuration
 */

// App constants
define('APP_NAME', getenv('APP_NAME') ?: 'DJ Platform');
define('APP_VERSION', '3.0.0');
define('URL_ROOT', rtrim(getenv('URL_ROOT') ?: 'http://localhost/djro_v3.0', '/'));

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'djro_db');

// Paths
define('APPROOT', dirname(dirname(__FILE__)));

// SMTP Configuration (PHPMailer)
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'localhost');
define('SMTP_USER', getenv('SMTP_USER') ?: '');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('SMTP_PORT', (int)(getenv('SMTP_PORT') ?: 587));
define('SMTP_SECURE', getenv('SMTP_SECURE') ?: '');
define('SMTP_FROM', getenv('SMTP_FROM') ?: 'no-reply@djpro.com');
define('SMTP_FROM_NAME', getenv('SMTP_FROM_NAME') ?: 'DJPRO Platform');
