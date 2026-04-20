<?php
/**
 * Unified Connection and Session Configuration
 */

// 1. Error reporting (must be first)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// 2. Global Constants
if (!defined('IS_CLOUD')) {
    define('IS_CLOUD', (getenv('RENDER') == 'true' || getenv('IS_CLOUD') == 'true' || getenv('DB_HOST') != ''));
}

if (!defined('WEB_ROOT')) {
    define('WEB_ROOT', IS_CLOUD ? '/' : '/Exam-Seating-Arrangement-main/'); 
}

// 3. Unified Session Initialization (must be before any output)
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => (bool)IS_CLOUD,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// 4. Load Dependencies
require_once(__DIR__ . '/db_compat.php');
require_once(__DIR__ . '/init_sqlite.php');
require_once(__DIR__ . '/functions.php');

// 5. Database Setup
$sqlite_path = __DIR__ . '/../database.sqlite';
$sql_source = __DIR__ . '/../DB/exam_hall.sql';

if (!defined('DIR_ROOT')) {
    define('DIR_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

// Ensure database is initialized
init_sqlite($sql_source, $sqlite_path);

// 6. Establish PDO Connection
try {
    $conn = new SQLitePDO("sqlite:" . $sqlite_path);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
