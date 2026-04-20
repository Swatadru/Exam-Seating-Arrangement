<?php
include_once(__DIR__ . '/connect.php');

// Enhanced session check: ensuring the user is logged in as admin
if (!isset($_SESSION["email"]) && !isset($_SESSION["id"])) {
    // If not in a cloud environment, ensure pathing is consistent
    $login_path = WEB_ROOT . 'admin/login.php';
    echo "<script>window.location.href = '$login_path';</script>";
    exit();
} else { 
?>
   
    <div id="main-wrapper">
        
        <div class="header glass-effect">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span>EDWARDS ACADEMY</span>
                    </a>
                </div>
                
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> 
                            <a class="nav-link nav-toggler hidden-md-up text-muted" href="javascript:void(0)"><i class="fa fa-bars"></i></a> 
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php 
                                $sql = "select * from admin where id = '".$_SESSION["id"]."'";
                                $query=$conn->query($sql);
                                $row=mysqli_fetch_array($query);
                                extract($row);
                                ?>
                                <img src="../assets/uploadImage/Profile/<?=$image?>" alt="user" class="profile-pic" style="width: 40px; height: 40px; border-radius: 10px; border: 2px solid var(--border-glass);" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn glass-effect" style="background: var(--bg-card) !important; border: 1px solid var(--border-glass) !important;">
                                <ul class="dropdown-user">
                                    <li><a href="profile.php" class="text-white px-3 py-2 d-block"><i class="ti-user mr-2"></i> Profile</a></li>
                                    <li><a href="changepassword.php" class="text-white px-3 py-2 d-block"><i class="ti-key mr-2"></i> Password</a></li>
                                    <li><hr class="dropdown-divider opacity-10"></li>
                                    <li><a href="logout.php" class="text-white px-3 py-2 d-block"><i class="fa fa-power-off mr-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <?php } ?>