<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');
include('../../includes/functions.php');

if(isset($_POST['btn_save'])) {
    $stmt = $conn->prepare("INSERT INTO `room` (`type_id`,`name`,`strength`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['type_id'], $_POST['name'], $_POST['strength']);

    if ($stmt->execute()) {
        $_SESSION['success']=' Record Successfully Added';
    } else {
        $_SESSION['error']='Something Went Wrong';
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_room.php");
exit();
?>
