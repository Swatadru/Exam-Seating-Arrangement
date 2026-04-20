<?php
// Unified Session Initialization
if (session_status() == PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 0,
        'cookie_path' => '/',
        'cookie_secure' => (bool)getenv('RENDER'), // Secure only on cloud (HTTPS)
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

// Error reporting for legacy compatibility
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Load Compatibility Layer and Helpers
require_once(__DIR__ . '/db_compat.php');
require_once(__DIR__ . '/init_sqlite.php');
require_once(__DIR__ . '/functions.php');

// Environment detection
if (!defined('IS_CLOUD')) {
    define('IS_CLOUD', getenv('RENDER') || getenv('IS_CLOUD') || getenv('DB_HOST'));
}

// Database configuration
$sqlite_path = __DIR__ . '/../database.sqlite';
$sql_source = __DIR__ . '/../DB/exam_hall.sql';

// Project root for absolute pathing
if (!defined('DIR_ROOT')) {
    define('DIR_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

// Web root for URLs (adjust this if not at server root)
if (!defined('WEB_ROOT')) {
    define('WEB_ROOT', IS_CLOUD ? '/' : '/Exam-Seating-Arrangement-main/'); 
}

// Initialize SQLite database if it doesn't exist
init_sqlite($sql_source, $sqlite_path);

// Establishing Connection using Compatibility Layer
try {
    $conn = new SQLitePDO("sqlite:" . $sqlite_path);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
