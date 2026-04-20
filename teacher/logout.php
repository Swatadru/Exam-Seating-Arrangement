<?php
include_once(__DIR__ . '/../includes/connect.php');
session_destroy();
header("Location: login.php");
exit();
?>
