<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');
include('../../includes/functions.php');

if(isset($_POST['btn_save'])) {
    $stmt = $conn->prepare("INSERT INTO `room_type` (`roomname`) VALUES (?)");
    $stmt->bind_param("s", $_POST['roomname']);

    if ($stmt->execute()) {
        $_SESSION['success']=' Record Successfully Added';
    } else {
        $_SESSION['error']='Something Went Wrong';
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_roomtype.php");
exit();
?>



