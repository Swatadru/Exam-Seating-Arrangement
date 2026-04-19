<link rel="stylesheet" href="../assets/popup_style.css">
<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');
include('../../includes/functions.php');

if (isset($_POST['btn_save'])) {
    $stud_id = $_POST['stud_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("SELECT id FROM `tbl_attendence` WHERE stud_id = ? AND date = ?");
    $stmt->bind_param("ss", $stud_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row1 = $result->fetch_assoc();

    if (empty($row1)) {
        $stmt2 = $conn->prepare("SELECT classname FROM `tbl_student` WHERE id = ?");
        $stmt2->bind_param("s", $stud_id);
        $stmt2->execute();
        $row2 = $stmt2->get_result()->fetch_assoc();

        $stmt3 = $conn->prepare("INSERT INTO `tbl_attendance` (`stud_id`, `classname`, `date`, `status`) VALUES (?, ?, ?, ?)");
        $stmt3->bind_param("ssss", $stud_id, $row2['classname'], $date, $status);
        
        if ($stmt3->execute()) {
            $_SESSION['success'] = ' Record Successfully Added';
            header("Location: ../view_attendence.php");
            exit();
        } else {
            $_SESSION['error'] = 'Something Went Wrong';
            header("Location: ../view_attendence.php");
            exit();
        }
    } else { ?>
        <div class="popup popup--icon -error js_error-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Record Already Exists</h3>
                <p></p>
                <p>
                    <a href="../view_attendence.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                </p>
            </div>
        </div>
    <?php }
}
?>
 
