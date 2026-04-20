<?php include('../includes/head.php');?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $row_login['title'];?> - Student Login</title>
        <link rel="stylesheet" href="../assets/style1.css">
      </head>

      <body>
        <div class='intro'>
            <h1 class='logo-header'>
                <span class='logo'>WELCOME</span>
                <span class='logo'>TO </span>
                <span class='logo'>STUDENT</span>
                <span class='logo'>WEBSITE</span>                
            </h1>
        </div>
        <script src="../assets/app.js"></script>
      </body>
</html>

<link rel="stylesheet" href="../assets/popup_style.css">

   <?php
  include('../includes/connect.php');
  include('../includes/functions.php');
if(isset($_POST['btn_login']))
{
  $unm = $_POST['email'];
  $password = $_POST['password'];
  $pass = hashPassword($password);

  $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE semail = ? AND password = ?");
  $stmt->bind_param("ss", $unm, $pass);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  
  if (!verifyCSRFToken($_POST['csrf_token'])) {
      die("CSRF token validation failed. Possible attack detected.");
  }
    
     if($row) {
         $_SESSION["id"] = $row['id'];
         $_SESSION["password"] = $row['password'];
         $_SESSION["semail"] = $row['semail'];
         
         ?>
         <div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p>Login Successfully</p>
    <p>
     <?php echo "<script>setTimeout(\"location.href = 'dashboard.php';\",1500);</script>"; ?>
    </p>
  </div>
</div>
  
     <?php
    }
    else {?>
     <div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Error 
    </h1>
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

    <div id="main-wrapper">
        <div class="unix-login">
             <?php
             $sql_login = "select * from manage_website"; 
             $result_login = $conn->query($sql_login);
             $row_login = mysqli_fetch_array($result_login);
             ?>
            <div class="container-fluid"  style="background-image: url('../assets/uploadImage/Logo/<?php echo $row_login['background_login_image'];?>'); background-size: cover;">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <center><img src="../assets/uploadImage/Logo/logo 4.jpg" style="width:80%;"></center><br>
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
                                    <p><a href="../admin/login.php"> Admin Login</a> | <a href="../teacher/login.php"> Teacher Login</a></p>
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
    <script src="../assets/js/jquery.slimscroll.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/js/custom.min.js"></script>

</body>

</html>