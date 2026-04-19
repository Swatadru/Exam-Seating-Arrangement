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
    <title><?php echo $row['title'];?> - Welcome</title>
    <link href="assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #fff;
            overflow: hidden;
        }
        .portal-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            padding: 50px 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            max-width: 900px;
            width: 95%;
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo {
            width: 100px;
            margin-bottom: 25px;
            filter: drop-shadow(0 0 15px rgba(255,255,255,0.3));
        }
        h1 { font-weight: 600; margin-bottom: 10px; font-size: 2.5rem; letter-spacing: -1px; }
        p { opacity: 0.8; margin-bottom: 40px; }
        .btn-portal {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            margin: 10px 0;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            border: none;
            font-size: 0.9rem;
        }
        .btn-admin { background: linear-gradient(45deg, #ff4b2b, #ff416c); color: #fff; }
        .btn-teacher { background: linear-gradient(45deg, #0082c8, #667eea); color: #fff; }
        .btn-student { background: linear-gradient(45deg, #00c853, #b2ff59); color: #000; }
        
        .btn-portal:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            filter: brightness(1.2);
            color: #fff !important;
        }

        @media (max-width: 768px) {
            .portal-card {
                padding: 40px 20px;
            }
            h1 { font-size: 1.8rem; }
            .btn-portal {
                padding: 15px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="portal-card">
        <img src="assets/uploadImage/Logo/<?php echo $row['logo'];?>" alt="Logo" class="logo">
        <h1><?php echo $row['title'];?></h1>
        <p>Seamless Exam Hall Management</p>
        <div class="row">
            <div class="col-md-4">
                <a href="admin/login.php" class="btn-portal btn-admin">Admin Portal</a>
            </div>
            <div class="col-md-4">
                <a href="teacher/login.php" class="btn-portal btn-teacher">Teacher Portal</a>
            </div>
            <div class="col-md-4">
                <a href="student/login.php" class="btn-portal btn-student">Student Portal</a>
            </div>
        </div>
        <div class="footer-note">
            <p>&copy; <?php echo date('Y'); ?> Exam Hall Management. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

