<?php
/**
 * Application Configuration
 */

// App constants
define('APP_NAME', 'DJ Platform');
define('APP_VERSION', '3.0.0');
define('URL_ROOT', 'http://localhost/djro_v3.0');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'djro_db');

// Paths
define('APPROOT', dirname(dirname(__FILE__)));

// SMTP Configuration (PHPMailer)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'stivenzambrano0208@gmail.com');
define('SMTP_PASS', 'kvucjhixojpuzefv');
define('SMTP_PORT', 587);
define('SMTP_FROM', 'no-reply@djpro.com');
define('SMTP_FROM_NAME', 'DJPRO Platform');
