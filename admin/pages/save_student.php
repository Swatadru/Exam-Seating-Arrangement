<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');

if(isset($_POST['btn_save'])) {
    try {
        $pass = hashPassword($_POST['password']);
        $stmt = $conn->prepare("INSERT INTO `tbl_student`(`stud_id`,`sfname`, `slname`, `classname`, `semail`,`password`, `sgender`, `sdob`, `scontact`, `saddress`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", 
            $_POST['stud_id'], $_POST['sfname'], $_POST['slname'], $_POST['classname'], 
            $_POST['semail'], $pass, $_POST['sgender'], $_POST['sdob'], 
            $_POST['scontact'], $_POST['saddress']
        );

        if ($stmt->execute()) {
            $_SESSION['success']='Record Successfully Added';
        } else {
            $_SESSION['error']='Failed to add student: ' . mysqli_error($conn);
        }
    } catch (Exception $e) {
        $_SESSION['error']='Database error: ' . $e->getMessage();
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_student.php");
exit();
?>
