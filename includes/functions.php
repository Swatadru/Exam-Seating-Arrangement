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
        $is_logged_in = false;
        $redirect = "";

        if ($type == 'admin' && (isset($_SESSION["email"]) || isset($_SESSION["id"]))) {
            $is_logged_in = true;
        } elseif ($type == 'student' && (isset($_SESSION["semail"]) || isset($_SESSION["id"]))) {
            $is_logged_in = true;
        } elseif ($type == 'teacher' && (isset($_SESSION["temail"]) || isset($_SESSION["id"]))) {
            $is_logged_in = true;
        }

        if (!$is_logged_in) {
            $redirect = WEB_ROOT . $type . "/login.php";
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

