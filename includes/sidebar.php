<?php 
include_once(__DIR__ . '/connect.php');
if (isset($_SESSION["id"])) {
    $sql = "select * from admin where id = '".$_SESSION["id"]."'";
    $result=$conn->query($sql);
    $row1=mysqli_fetch_array($result);
   
    $q = "select * from tbl_permission_role where role_id='".$row1['group_id']."'";
    $ress=$conn->query($q);
   
     $name = array();
    while($row=mysqli_fetch_array($ress)){
        $sql = "select * from tbl_permission where id = '".$row['permission_id']."'";
        $result=$conn->query($sql);
        if(mysqli_num_rows($result) > 0){
            $row2=mysqli_fetch_array($result);
            array_push($name,$row2[1]);
        }
    }
    $_SESSION['name']=$name;
    $useroles=$_SESSION['name'];
}
?>


        <div class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label text-muted px-4 py-2 mt-4" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1rem;">Main Navigation</li>
                        
                        <li> <a href="dashboard.php"><i class="fa fa-th-large"></i><span class="hide-menu">Dashboard</span></a></li>

                        <?php if(isset($useroles)){  if(in_array("manage_attendence",$useroles)){ ?> 
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-clock-o"></i><span class="hide-menu">Attendance</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="add_attendence.php">Add Attendance</a></li>
                                <li><a href="view_attendence.php">View Attendance</a></li>
                            </ul>
                        </li>
                        <?php } } ?>

                        <?php if(isset($useroles)){  if(in_array("manage_teacher",$useroles)){ ?> 
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-user-circle"></i><span class="hide-menu">Teachers</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="add_teacher.php">Add Teacher</a></li>
                                <li><a href="view_teacher.php">View Teacher</a></li>
                            </ul>
                        </li>
                        <?php } } ?> 

                        <?php if(isset($useroles)){  if(in_array("manage_student",$useroles)){ ?> 
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-graduation-cap"></i><span class="hide-menu">Students</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="add_student.php">Add Student</a></li>
                                <li><a href="view_student.php">View Student</a></li>
                            </ul>
                        </li>
                        <?php } } ?>

                        <?php if(isset($useroles)){  if(in_array("manage_subject",$useroles)){ ?> 
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Subjects</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="add_subject.php">Add Subject</a></li>
                                <li><a href="view_subject.php">View Subject</a></li>
                            </ul>
                        </li>
                        <?php } } ?>

                        <?php if(isset($useroles)){  if(in_array("manage_class",$useroles)){ ?> 
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-university"></i><span class="hide-menu">Classes</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="add_class.php">Add Class</a></li>
                                <li><a href="view_class.php">View Class</a></li>
                            </ul>
                        </li>
                        <?php } } ?>

                        <?php if(isset($useroles)){  if(in_array("manage_exam",$useroles)){ ?> 
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-file-text"></i><span class="hide-menu">Exam Management</span></a>
                            <ul aria-expanded="false" class="collapse px-4"> 
                                <li><a href="add_roomtype.php">Add Room Type</a></li>
                                <li><a href="view_roomtype.php">View Room Type</a></li>
                                <li><a href="add_room.php">Add Room</a></li>
                                <li><a href="view_room.php">View Room</a></li>
                                <li><a href="add_exam.php">Add Exam</a></li>
                                <li><a href="view_exam.php">View Exam</a></li>
                                <li><a href="add_allotment.php">Add Allotment</a></li>
                                <li><a href="view_allotment.php">View Allotment</a></li>
                            </ul>
                        </li>
                        <?php } } ?>
                   
                        <?php if(isset($useroles)){  if(in_array("manage_user",$useroles)){ ?> 
                        <li class="nav-label text-muted px-4 py-2 mt-4" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1rem;">Administration</li>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Users</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="add_user.php">Add Users</a></li>
                                <li><a href="view_user.php">View Users</a></li>
                            </ul>
                        </li>
                        <?php } } ?>

                        <?php if($_SESSION["username"]=='admin') { ?>
                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-shield"></i><span class="hide-menu">Permissions</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="assign_role.php">assign role</a></li>
                                <li><a href="view_role.php">View Role</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-sliders"></i><span class="hide-menu">Setting</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="manage_website.php">Appearance</a></li>
                                <li><a href="email_config.php">Email Config</a></li>
                            </ul>
                        </li> 
                        <li class="nav-label text-muted px-4 py-2 mt-4" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1rem;">Reports</li> 
                        <li>  <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Reports</span></a>
                            <ul aria-expanded="false" class="collapse px-4">
                                <li><a href="today_exam.php">Today's Exam</a></li>
                                <li><a href="report_exam.php">Exam Report</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>   
                </nav>
            </div>
        </div>


    
                    </ul>   
                </nav>
                




            </div>
           
        </div>
        