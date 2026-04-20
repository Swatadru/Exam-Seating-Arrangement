<?php include('../includes/head.php');?>
<?php include('../includes/header.php');?>

<?php include('../includes/sidebar.php');?>   
<?php
 date_default_timezone_set('Asia/Kolkata');
 $current_date = date('Y-m-d');

 $sql_currency = "select * from manage_website"; 
             $result_currency = $conn->query($sql_currency);
             $row_currency = mysqli_fetch_array($result_currency);
?>    
      
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row pt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary glass-effect">
                            <div class="widget-stat-card">
                                <div class="widget-icon" style="background: rgba(92, 124, 250, 0.2);"><i class="fa fa-user-circle"></i></div>
                                <div class="stat-info">
                                    <?php 
                                    $sql="SELECT COUNT(*) FROM `tbl_teacher`";
                                    $res = $conn->query($sql);
                                    $row=mysqli_fetch_array($res);
                                    ?> 
                                    <h2><?php echo $row[0];?></h2>
                                    <p>Teachers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card glass-effect">
                            <div class="widget-stat-card">
                                <div class="widget-icon" style="background: rgba(236, 72, 153, 0.2); color: #ec4899;"><i class="fa fa-graduation-cap"></i></div>
                                <div class="stat-info">
                                    <?php 
                                    $sql="SELECT COUNT(*) FROM `tbl_student`";
                                    $res = $conn->query($sql);
                                    $row=mysqli_fetch_array($res);
                                    ?>
                                    <h2 style="color: #ec4899;"><?php echo $row[0];?></h2>
                                    <p>Students</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card glass-effect">
                            <div class="widget-stat-card">
                                <div class="widget-icon" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;"><i class="fa fa-university"></i></div>
                                <div class="stat-info">
                                    <?php 
                                    $sql="SELECT COUNT(*) FROM `tbl_class`";
                                    $res = $conn->query($sql);
                                    $row=mysqli_fetch_array($res);
                                    ?>
                                    <h2 style="color: #ef4444;"><?php echo $row[0];?></h2>
                                    <p>Classes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card glass-effect">
                            <div class="widget-stat-card">
                                <div class="widget-icon" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b;"><i class="fa fa-book"></i></div>
                                <div class="stat-info">
                                     <?php 
                                     $sql="SELECT COUNT(*) FROM `tbl_subject`";
                                     $res = $conn->query($sql);
                                     $row=mysqli_fetch_array($res);
                                     ?> 
                                    <h2 style="color: #f59e0b;"><?php echo $row[0];?></h2>
                                    <p>Subjects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">View Exam</h3> </div>
                
            </div>
            <div class="card">
                            <div class="card-body">
                            
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Exam Name</th>
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php 
                                    include '../includes/connect.php';
                                  $sql1 = "SELECT * FROM  `exam`";
                                   $result1 = $conn->query($sql1);
                                   while($row = $result1->fetch_assoc()) { 
                                      ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                <a href="view_exam.php?id=<?=$row['id'];?>"><button type="button" class="btn btn-xs btn-danger" ><i class="fa fa-trash"></i></button></a>
                                                </td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
        </div>
            
            <?php include('../includes/footer.php');?>
