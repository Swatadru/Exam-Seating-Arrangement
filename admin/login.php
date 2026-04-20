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
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Standard CSS -->
    <link href="../assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/helper.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    
    <!-- Premium Login CSS -->
    <link href="../assets/css/premium_login.css" rel="stylesheet">
</head>
<body class="premium-login-body">
    <div class="login-background-overlay" style="background-image: url('../assets/uploadImage/Logo/<?php echo $row_head_title['background_login_image'];?>');"></div>
    
    <div class="premium-login-container">
        <div class="glass-card">
            <div class="login-header">
                <h2>Admin Login</h2>
                <p>Welcome back! Please enter your details.</p>
            </div>

            <?php if(isset($error)) { echo '<div class="alert-premium">'.$error.'</div>'; } ?>
            
            <form method="POST">
                <div class="form-group-premium">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-input-premium" placeholder="name@company.com" required="">
                </div>
                
                <div class="form-group-premium">
                    <label>Password</label>
                    <input type="password" name="password" class="form-input-premium" placeholder="••••••••" required="">
                </div>
                
                <button type="submit" name="btn_login" class="btn-premium">Sign In</button>
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            </form>
            
            <div class="links-container">
                <a href="../student/login.php">Student Portal</a>
                <span>|</span>
                <a href="../teacher/login.php">Teacher Portal</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../assets/js/lib/jquery/jquery.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
