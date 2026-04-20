<?php
include('../includes/connect.php');
include('../includes/functions.php');

if(isset($_POST['btn_login'])) {
    $unm = $_POST['email'];
    $password = $_POST['password'];
    $pass = hashPassword($password);

    if (!verifyCSRFToken($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    $stmt = $conn->prepare("SELECT * FROM tbl_teacher WHERE temail = ? AND password = ?");
    $stmt->bind_param("ss", $unm, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if($row) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["temail"] = $row['temail'];
        $_SESSION["fname"] = $row['tfname'];
        $_SESSION["lname"] = $row['tlname'];
        ?>
        <link rel="stylesheet" href="../assets/popup_style.css">
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Success</h3>
                <p>Login Successful</p>
                <p>
                    <script>setTimeout(function(){ location.href = 'dashboard.php'; }, 1500);</script>
                </p>
            </div>
        </div>
        <?php
    } else {
        ?>
        <link rel="stylesheet" href="../assets/popup_style.css">
        <div class="popup popup--icon -error js_error-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Error</h3>
                <p>Invalid Email or Password</p>
                <p>
                    <a href="login.php"><button class="button button--error">Close</button></a>
                </p>
            </div>
        </div>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sql_login = "select * from manage_website"; 
    $result_login = $conn->query($sql_login);
    $row_login = mysqli_fetch_array($result_login);
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row_login['title'];?> - Teacher Login</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Dependencies -->
    <link href="../assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/premium_login.css" rel="stylesheet">
</head>
<body class="premium-login-body">
    <div class="login-background-overlay" style="background-image: url('../assets/uploadImage/Logo/<?php echo $row_login['background_login_image'];?>');"></div>
    
    <div class="premium-login-container">
        <div class="glass-card">
            <div class="login-header">
                <h2>Teacher Portal</h2>
                <p>Sign in to manage your exams and students</p>
            </div>

            <form method="POST">
                <div class="form-group-premium">
                    <label>Staff Email</label>
                    <input type="email" name="email" class="form-input-premium" placeholder="teacher@school.edu" required="">
                </div>
                
                <div class="form-group-premium">
                    <label>Password</label>
                    <input type="password" name="password" class="form-input-premium" placeholder="••••••••" required="">
                </div>
                
                <button type="submit" name="btn_login" class="btn-premium">Sign In</button>
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            </form>
            
            <div class="links-container">
                <a href="../admin/login.php">Admin Login</a>
                <span>|</span>
                <a href="../student/login.php">Student Portal</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../assets/js/lib/jquery/jquery.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

</body>

</html>