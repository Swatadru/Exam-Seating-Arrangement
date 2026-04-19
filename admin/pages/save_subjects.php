<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');
include('../../includes/functions.php');

if(isset($_POST['btn_save'])) {
    $stmt = $conn->prepare("INSERT INTO `tbl_subject` (`class_id`,`subjectname`) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['class_id'], $_POST['subjectname']);

    if ($stmt->execute()) {
        $_SESSION['success']=' Record Successfully Added';
    } else {
        $_SESSION['error']='Something Went Wrong';
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_subject.php");
exit();
?>
