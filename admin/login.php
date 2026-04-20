<?php
include('../includes/connect.php');
include('../includes/functions.php');

if(isset($_POST['btn_login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pass = hashPassword($password);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if($row) {
        if (!verifyCSRFToken($_POST['csrf_token'])) {
            die("CSRF token validation failed. Possible attack detected.");
        }
        $_SESSION["id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        $_SESSION["email"] = $row['email'];
        $_SESSION["fname"] = $row['fname'];
        $_SESSION["lname"] = $row['lname'];
        $_SESSION["image"] = $row['image'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $sql_head_title = "select * from manage_website"; 
    $result_head_title = $conn->query($sql_head_title);
    $row_head_title = mysqli_fetch_array($result_head_title);
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row_head_title['title'];?> - Admin Login</title>
    <link href="../assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/helper.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="fix-header fix-sidebar">
    <div id="main-wrapper">
        <div class="unix-login">
            <div class="container-fluid" style="background-image: url('../assets/uploadImage/Logo/<?php echo $row_head_title['background_login_image'];?>'); background-size: cover;">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <center><h4>Admin Login</h4></center><br>
                                <?php if(isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required="">
                                    </div>
                                    <button type="submit" name="btn_login" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                </form>
                                <div class="register-link m-t-15 text-center">
                                    <p><a href="../student/login.php"> Student Login</a> | <a href="../teacher/login.php"> Teacher Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/lib/jquery/jquery.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
