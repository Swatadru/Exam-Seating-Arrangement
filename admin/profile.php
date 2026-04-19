<?php include('../includes/head.php');?>
<?php include('../includes/header.php');?>
<?php include('../includes/sidebar.php');?>
<?php include('../includes/functions.php');?>

 <?php
 include('../includes/connect.php');
if(isset($_POST["btn_update"]))
{
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];
  $dob = $_POST['dob'];
  $gender = $_POST['gender'];
  $old_image = $_POST['old_image'];

  $target_dir = "../assets/uploadImage/Profile/";
  $image1 = basename($_FILES["image"]["name"]);
  if($_FILES["image"]["tmp_name"]!=''){
    $image_path = $target_dir . $image1;
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
       if($old_image && file_exists($target_dir . $old_image)) {
           @unlink($target_dir . $old_image);
       }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
  }
  else {
     $image1 = $old_image;
  }
  
  $stmt = $conn->prepare("UPDATE `admin` SET `fname`=?, `lname`=?, `email`=?, `contact`=?, `dob`=?, `gender`=?, `image`=? WHERE id = ?");
  $stmt->bind_param("sssssssi", $fname, $lname, $email, $contact, $dob, $gender, $image1, $_SESSION["id"]);

    if ($stmt->execute()) {
        $_SESSION['success']='Record Successfully Updated';
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error']='Something Went Wrong';
    }
}

$stmt_get = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt_get->bind_param("i", $_SESSION["id"]);
$stmt_get->execute();
$row = $stmt_get->get_result()->fetch_assoc();

$fname = $row['fname'];
$lname = $row['lname'];
$email = $row['email'];
$contact = $row['contact'];
$dob1 = $row['dob'];
$gender = $row['gender'];
$image = $row['image'];
?> 
      
        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> Profile</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
           
            <div class="container-fluid">
                
                <div class="row">
                    <div class="col-lg-8" style="margin-left: 10%;">
                        <div class="card">
                            <div class="card-title">
                               
                            </div>
                            <div class="card-body">
                                <div class="input-states">
                                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">First Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text"  value="<?php echo $fname;?>"  name="fname" class="form-control" id="event" onkeydown="return alphaOnly(event);" required>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Last Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text"  value="<?php echo $lname;?>"  name="lname" class="form-control" id="event" onkeydown="return alphaOnly(event);" required>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="<?php echo $email;?>"  name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"   class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">
                                                   <select name="gender" class="form-control" required>
                                                     <option value="Male"  <?php if($gender=="Male"){ echo "selected";}?>>Male</option>
                                                      <option value="Female" <?php if($gender=="Female"){ echo "selected";}?>>Female</option>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Date Of Birth</label>
                                                <div class="col-sm-9">
                                                    <input type="date" value="<?php echo $dob1;?>" name="dob" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Contact</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="<?php echo $contact;?>"  name="contact" class="form-control" id="tbNumbers" minlength="10" maxlength="10" onkeypress="javascript:return isNumber(event)" required>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Image</label>
                                                <div class="col-sm-9">
                                  <image class="profile-img" src="../assets/uploadImage/Profile/<?=$image?>" style="height:30%;width:50%;">
                  <input type="hidden" value="<?=$image?>" name="old_image">
                          <input type="file" class="form-control" name="image">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="btn_update" class="btn btn-primary btn-flat m-b-30 m-t-30">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>

<?php include('../includes/footer.php');?>

<link rel="stylesheet" href="../assets/popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);  
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Error 
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>
