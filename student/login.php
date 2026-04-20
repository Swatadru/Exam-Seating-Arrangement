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

    $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE semail = ? AND password = ?");
    $stmt->bind_param("ss", $unm, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if($row) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["semail"] = $row['semail'];
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
    <title><?php echo $row_login['title'];?> - Student Login</title>
    <link href="../assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/premium_theme.css" rel="stylesheet">
</head>
<body class="premium-login-container">
    <div class="premium-login-bg"></div>
    
    <div class="login-card glass-effect animated zoomIn">
        <div class="login-header">
            <h2>Student Portal</h2>
        </div>
        <div class="login-form">
            <form method="POST">
                <div class="form-group mb-4">
                    <label class="text-muted mb-2">Student Email</label>
                    <input type="email" name="email" class="form-control" placeholder="student@example.com" required="" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                </div>
                <div class="form-group mb-4">
                    <label class="text-muted mb-2">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required="" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                </div>
                <button type="submit" name="btn_login" class="btn btn-primary w-100 py-3 mt-2">Student Sign In</button>
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            </form>
            <div class="text-center mt-4">
                <p class="text-muted small">
                    <a href="../admin/login.php" class="text-accent underline">Admin Access</a> | 
                    <a href="../teacher/login.php" class="text-accent underline">Teacher Access</a>
                </p>
            </div>
        </div>
    </div>

    <script src="../assets/js/lib/jquery/jquery.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>