<?php include('../includes/head.php');?>
<?php include('../includes/header.php');?>
<?php include('../includes/sidebar.php');?>
<?php include('../includes/functions.php');?>

 <?php
 include('../includes/connect.php');
 date_default_timezone_set('Asia/Kolkata');
 $current_date = date('Y-m-d');

if(isset($_POST["btn_update"]))
{
    $tfname = $_POST['tfname'];
    $tlname = $_POST['tlname'];
    $classname = $_POST['classname'];
    $subjectname = $_POST['subjectname'];
    $temail = $_POST['temail'];
    $tgender = $_POST['tgender'];
    $tdob = $_POST['tdob'];
    $tcontact = $_POST['tcontact'];
    $taddress = $_POST['taddress'];

    if($_POST["password"]!='')
    {
        if($_POST['password']==$_POST['cpassword'])
        {
            $pass = hashPassword($_POST['password']);
            $stmt = $conn->prepare("UPDATE `tbl_teacher` SET `tfname`=?, `tlname`=?, `classname`=?, `subjectname`=?, `temail`=?, `tgender`=?, `tdob`=?, `tcontact`=?, `taddress`=?, `password`=? WHERE `id`=?");
            $stmt->bind_param("ssssssssssi", $tfname, $tlname, $classname, $subjectname, $temail, $tgender, $tdob, $tcontact, $taddress, $pass, $_GET['id']);
        }
        else
        {
            $_SESSION['error']='Password and Confirm Password dont match';
            header("Location: edit_teacher.php?id=".$_GET['id']);
            exit();
        }
    }
    else
    {
        $pass = $_POST['old_password'];
        $stmt = $conn->prepare("UPDATE `tbl_teacher` SET `tfname`=?, `tlname`=?, `classname`=?, `subjectname`=?, `temail`=?, `tgender`=?, `tdob`=?, `tcontact`=?, `taddress`=?, `password`=? WHERE `id`=?");
        $stmt->bind_param("ssssssssssi", $tfname, $tlname, $classname, $subjectname, $temail, $tgender, $tdob, $tcontact, $taddress, $pass, $_GET['id']);
    }
    
    if ($stmt->execute()) {
        $_SESSION['success']=' Record Successfully Updated';
        header("Location: view_teacher.php");
        exit();
    } else {
        $_SESSION['error']='Something Went Wrong';
        header("Location: view_teacher.php");
        exit();
    }
}

$stmt_get = $conn->prepare("SELECT * FROM `tbl_teacher` WHERE id=?");
$stmt_get->bind_param("i", $_GET["id"]);
$stmt_get->execute();
$row = $stmt_get->get_result()->fetch_assoc();

$tfname = $row['tfname'];
$tlname = $row['tlname'];
$classname = $row['classname'];
$subjectname = $row['subjectname'];
$temail = $row['temail'];
$gender = $row['tgender'];
$tdob = $row['tdob'];
$tcontact = $row['tcontact'];
$taddress = $row['taddress'];
$password = $row['password'];

?> 

        <div class="page-wrapper">
       
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Teacher Management</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Teacher Management</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid">
              
                <div class="row">
                    <div class="col-lg-8" style="    margin-left: 10%;">
                        <div class="card">
                            <div class="card-title">
                               
                            </div>
                            <div class="card-body">
                                <div class="input-states">
                                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" name="teacherform">
<input type="hidden" name="old_password" class="form-control" value="<?php echo $password;?>">
                                   <input type="hidden" name="currnt_date" class="form-control" value="<?php echo $current_date;?>">

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">First Name</label>
                                                <div class="col-sm-9">
                                                  <input type="text" name="tfname" class="form-control" placeholder="First Name" id="event" onkeydown="return alphaOnly(event);" value="<?php echo $tfname; ?>" required="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Last Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text"  name="tlname" id="lname" class="form-control" id="event" onkeydown="return alphaOnly(event);" placeholder="Last Name" value="<?php echo $tlname; ?>" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Class</label>
                                                <div class="col-sm-9">
                                                    <select type="text" name="classname" class="form-control" id="class_id"  placeholder="Class" required="">
                                                        <option value="">--Select Class--</option>
                                                            <?php  
                                                            $c1 = "SELECT * FROM `tbl_class`";
                                                            $result = $conn->query($c1);

                                                            if ($result->num_rows > 0) {
                                                                while ($row = mysqli_fetch_array($result)) {?>
                                                                    <option value="<?php echo $row["id"];?>"<?php if($classname==$row["id"]){ echo "Selected";}?>>
                                                                        <?php echo $row['classname'];?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            } else {
                                                            echo "0 results";
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label">Subject</label>
                <div class="col-sm-9">
                    <select type="text" name="subjectname" id="subject_id" class="form-control"   placeholder="subject" required="">
                        <option value="">--Select Subject--</option>
                            <?php  
                            $c1 = "SELECT * FROM `tbl_subject`";
                            $result = $conn->query($c1);

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {?>
                                    <option value="<?php echo $row["id"];?>" data-id="<?php echo $row["class_id"];?>" <?php if($subjectname==$row["id"]){ echo "selected";} if($row["class_id"]!==$classname){ echo 'style="display: none;"'; } ?> <?php if($subjectname==$row["id"]){ echo "Selected";}?>>
                                        <?php echo $row['subjectname'];?>
                                    </option>
                                    <?php
                                }
                            } else {
                            echo "0 results";
                                }
                            ?>
                    </select>
                </div>
            </div>
        </div>


                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="temail" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  placeholder="Email" value="<?php echo $temail; ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" id="password" placeholder="Password"  onkeyup='check();'  class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Confirm Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="cpassword" id="confirm_password" placeholder="Confirm Password"  onkeyup='check();'  class="form-control" >
                                                    <span id="message"></span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                          <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">
                                                   <select name="tgender" id="gender" class="form-control" required="">
                                                    <option value=" ">--Select Gender--</option>
                                                     <option value="Male" <?php if($gender=='Male'){ echo "Selected";}?>>Male</option>
                                                      <option value="Female" <?php if($gender=='Female'){ echo "Selected";}?>>Female</option>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                              <div class="row">
                                                <label class="col-sm-3 control-label">Date Of Birth</label>
                                                <div class="col-sm-9">
                                                  <input type="date" name="tdob" value="<?php echo $tdob; ?>" class="form-control" placeholder="Birth Date">
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Contact</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="tcontact" class="form-control" placeholder="Contact Number" id="tbNumbers" minlength="10" maxlength="10" onkeypress="javascript:return isNumber(event)" required="" value="<?php echo $tcontact; ?>">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="4" name="taddress" placeholder="Address" style="height: 120px;"><?php echo $taddress;?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="btn_update" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                
               
<?php include('../includes/footer.php');?>
<link rel="stylesheet" href="../assets/popup_style.css">
<script>
  var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'NOT Matching';
  }
}
</script>
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
    <script type="text/javascript">
 $(('#class_id')).change(function(){
    $(("#subject_id")).val('');
    $(("#subject_id")).children('option').hide();
    var class_id=$(this).val();
    $(("#subject_id")).children("option[data-id="+class_id+ "]").show();
    
  });
</script>
