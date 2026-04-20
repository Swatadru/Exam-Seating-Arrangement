<?php
require_once('includes/db_compat.php');

// Create a test DB in memory or temporary file
$sqlite_path = 'test_db.sqlite';
$conn = new SQLitePDO("sqlite:" . $sqlite_path);

// Create table
$conn->exec("CREATE TABLE IF NOT EXISTS test_teacher (id INTEGER PRIMARY KEY, name TEXT, email TEXT)");

// Test prepare and bind_param
$stmt = $conn->prepare("INSERT INTO test_teacher (name, email) VALUES (?, ?)");
$name = "Test Name";
$email = "test@example.com";

// Attempt to bind
$stmt->bind_param("ss", $name, $email);

if ($stmt->execute()) {
    echo "Insert successfully!\n";
} else {
    echo "Insert failed: " . mysqli_error($conn) . "\n";
}

// Test query
$res = $conn->query("SELECT * FROM test_teacher");
if ($res) {
    echo "Rows: " . $res->num_rows . "\n";
    while ($row = mysqli_fetch_assoc($res)) {
        print_r($row);
    }
} else {
    echo "Query failed\n";
}

unlink($sqlite_path);
?>
