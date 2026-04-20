<?php
function sanitize($conn, $data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize($conn, $value);
        }
    } else {
        $data = mysqli_real_escape_string($conn, trim($data));
        // Only use htmlspecialchars for output, not for DB insertion
        // $data = htmlspecialchars($data); 
    }
    return $data;
}

function createSalt() {
    return '2123293dsj2hu2nikhiljdsd';
}

function hashPassword($password) {
    $passw = hash('sha256', $password);
    $salt = createSalt();
    return hash('sha256', $salt . $passw);
}

function checkLogin($type = 'admin') {
    if ($type == 'admin' && !isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }
    if ($type == 'student' && !isset($_SESSION["semail"])) {
        header("Location: login.php");
        exit();
    }
    if ($type == 'teacher' && !isset($_SESSION["temail"])) {
        header("Location: login.php");
        exit();
    }
}

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}
?>
