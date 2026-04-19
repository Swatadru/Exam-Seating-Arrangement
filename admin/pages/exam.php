<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');
include('../../includes/functions.php');

if(isset($_POST['btn_save'])) {
    $stmt = $conn->prepare("INSERT INTO `exam` (`class_id`,`subject_id`,`exam_date`,`start_time`,`end_time`,`name`,`added_date`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $added_date = date('Y-m-d');
    $stmt->bind_param("sssssss", 
        $_POST['class_id'], 
        $_POST['subject_id'], 
        $_POST['exam_date'], 
        $_POST['start_time'], 
        $_POST['end_time'], 
        $_POST['name'], 
        $added_date
    );

    if ($stmt->execute()) {
        $_SESSION['success']=' Record Successfully Added';
    } else {
        $_SESSION['error']='Something Went Wrong';
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_exam.php");
exit();
?>
