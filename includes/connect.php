<?php
// Error reporting for legacy compatibility
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Load Compatibility Layer
require_once(__DIR__ . '/db_compat.php');
require_once(__DIR__ . '/init_sqlite.php');

// Database configuration
$sqlite_path = __DIR__ . '/../database.sqlite';
$sql_source = __DIR__ . '/../DB/exam_hall.sql';

// Project root for absolute pathing
if (!defined('DIR_ROOT')) {
    define('DIR_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

// Web root for URLs (adjust this if not at server root)
if (!defined('WEB_ROOT')) {
    $is_cloud = getenv('RENDER') || getenv('DB_HOST');
    define('WEB_ROOT', $is_cloud ? '/' : '/Exam-Seating-Arrangement-main/'); 
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

// Start Session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
