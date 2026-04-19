<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../../includes/connect.php');
include('../../includes/functions.php');

if(isset($_POST['btn_save'])) {
    $pass = hashPassword($_POST['password']);
    
    $image = $_FILES['image']['name'];
    $target = "../../assets/uploadImage/Profile/".basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }

    $stmt = $conn->prepare("INSERT INTO admin (username, email, password, fname, lname, gender, dob, contact, address, created_on, image, group_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $username = 'user'; // As per original code
    $stmt->bind_param("ssssssssssss", 
        $username,
        $_POST['email'],
        $pass,
        $_POST['fname'],
        $_POST['lname'],
        $_POST['gender'],
        $_POST['dob'],
        $_POST['contact'],
        $_POST['address'],
        $current_date,
        $image,
        $_POST['group_id']
    );

    if ($stmt->execute()) {
        $_SESSION['success']=' Record Successfully Added';
    } else {
        $_SESSION['error']='Something Went Wrong';
    }
} else {
    $_SESSION['error']='Access Denied';
}

header("Location: ../view_user.php");
exit();
?>
