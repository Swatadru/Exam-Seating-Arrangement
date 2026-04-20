<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');

if(isset($_POST['btn_save'])) {
    try {
        $pass = hashPassword($_POST['password']);
        $stmt = $conn->prepare("INSERT INTO `tbl_teacher` (`tfname`, `tlname`, `classname`, `subjectname`, `temail`,`password`, `tgender`, `tdob`, `tcontact`, `taddress`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", 
            $_POST['tfname'], $_POST['tlname'], $_POST['classname'], $_POST['subjectname'], 
            $_POST['temail'], $pass, $_POST['tgender'], $_POST['tdob'], 
            $_POST['tcontact'], $_POST['taddress']
        );

        if ($stmt->execute()) {
            $_SESSION['success']='Record Successfully Added';
        } else {
            $_SESSION['error']='Failed to add record: ' . mysqli_error($conn);
        }
    } catch (Exception $e) {
        $_SESSION['error']='Database error: ' . $e->getMessage();
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_teacher.php");
exit();
?>
