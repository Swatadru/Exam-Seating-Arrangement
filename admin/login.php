<?php
include('../includes/connect.php');
include('../includes/functions.php');
?>
<link rel="stylesheet" href="../assets/popup_style.css">
<?php
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
        
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">Success</h3>
            <p>Login Successful</p>
            <p>
              <script>
                setTimeout(function() {
                  window.location.href = "<?php echo WEB_ROOT; ?>admin/dashboard.php";
                }, 1500);
              </script>
            </p>
          </div>
        </div>
        <?php
    } else {
        ?>
        <div class="popup popup--icon -error js_error-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">Error</h3>
            <p>Invalid Email or Password</p>
            <p>
              <a href="login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
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
    $sql_head_title = "select * from manage_website"; 
    $result_head_title = $conn->query($sql_head_title);
    $row_head_title = mysqli_fetch_array($result_head_title);
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row_head_title['title'];?> - Admin Login</title>
    <link href="../assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/premium_theme.css" rel="stylesheet">
</head>
<body class="premium-login-container">
    <div class="premium-login-bg"></div>
    
    <div class="login-card glass-effect animated zoomIn">
        <div class="login-header">
            <h2>Admin Portal</h2>
        </div>
        <div class="login-form">
            <?php if(isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
            <form method="POST">
                <div class="form-group mb-4">
                    <label class="text-muted mb-2">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" required="" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                </div>
                <div class="form-group mb-4">
                    <label class="text-muted mb-2">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required="" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                </div>
                <button type="submit" name="btn_login" class="btn btn-primary w-100 py-3 mt-2">Access Dashboard</button>
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            </form>
            <div class="text-center mt-4">
                <p class="text-muted small">
                    <a href="../student/login.php" class="text-accent underline">Student Access</a> | 
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
