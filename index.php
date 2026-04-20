<?php
include('includes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $sql = "select * from manage_website"; 
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EDWARDS ACADEMY - Entrance</title>
    <link href="assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/premium_theme.css" rel="stylesheet">
    <style>
        .portal-card {
            border-radius: 24px;
            padding: 50px 30px;
            animation: fadeIn 0.8s ease-out;
            max-width: 900px;
            width: 95%;
            z-index: 2;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 { margin-bottom: 20px; font-size: 3rem; background: linear-gradient(to right, #fff, var(--text-muted)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-portal {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.2rem;
            margin: 10px 0;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.4s ease;
            text-decoration: none !important;
            border: none;
            color: #fff !important;
        }
        .btn-admin { background: linear-gradient(45deg, #4338ca, #6366f1); }
        .btn-teacher { background: linear-gradient(45deg, #0ea5e9, #38bdf8); }
        .btn-student { background: linear-gradient(45deg, #059669, #10b981); }
        
        .btn-portal:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.4); }
    </style>
</head>
<body class="premium-login-container">
    <div class="premium-login-bg"></div>
    <div class="portal-card glass-effect">
        <h1>EDWARDS ACADEMY</h1>
        <p class="text-muted mb-5">State-of-the-art Exam Hall Management Portal</p>
        <div class="row">
            <div class="col-md-4">
                <a href="admin/login.php" class="btn-portal btn-admin">Admin Entrance</a>
            </div>
            <div class="col-md-4">
                <a href="teacher/login.php" class="btn-portal btn-teacher">Teacher Entrance</a>
            </div>
            <div class="col-md-4">
                <a href="student/login.php" class="btn-portal btn-student">Student Entrance</a>
            </div>
        </div>
        <div class="mt-5 opacity-50">
            <p>&copy; <?php echo date('Y'); ?> Edwards Academy. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

