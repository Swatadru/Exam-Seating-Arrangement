<?php
if (!function_exists('sanitize')) {
    function sanitize($conn, $data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = sanitize($conn, $value);
            }
        } else {
            $data = mysqli_real_escape_string($conn, trim($data));
        }
        return $data;
    }
}

if (!function_exists('createSalt')) {
    function createSalt() {
        return '2123293dsj2hu2nikhiljdsd';
    }
}

if (!function_exists('hashPassword')) {
    function hashPassword($password) {
        $passw = hash('sha256', $password);
        $salt = createSalt();
        return hash('sha256', $salt . $passw);
    }
}

if (!function_exists('checkLogin')) {
    function checkLogin($type = 'admin') {
        if ($type == 'admin' && !isset($_SESSION["email"])) {
            $redirect = WEB_ROOT . "admin/login.php";
            echo "<script>window.location.href = '$redirect';</script>";
            exit();
        }
        if ($type == 'student' && !isset($_SESSION["semail"])) {
            $redirect = WEB_ROOT . "student/login.php";
            echo "<script>window.location.href = '$redirect';</script>";
            exit();
        }
        if ($type == 'teacher' && !isset($_SESSION["temail"])) {
            $redirect = WEB_ROOT . "teacher/login.php";
            echo "<script>window.location.href = '$redirect';</script>";
            exit();
        }
    }
}

if (!function_exists('generateCSRFToken')) {
    function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verifyCSRFToken')) {
    function verifyCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
}

