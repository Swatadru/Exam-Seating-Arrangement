<?php include('../includes/head.php');?>
<?php include('../includes/header1.php');?>
<?php include('../includes/stud_sidebar.php');?>
<link rel="stylesheet" href="../assets/css/seating.css">

<?php
include('../includes/connect.php');

if(!isset($_GET['allot_id']) || !isset($_GET['room_id'])) {
    echo "<script>location.href='dashboard.php';</script>";
    exit;
}

$allot_id = $_GET['allot_id'];
$room_id = $_GET['room_id'];
$my_id = $_SESSION['id'];

// Fetch Room and Exam details
$sql = "SELECT e.name as exam_name, r.name as room_name, r.strength 
        FROM allot a 
        JOIN exam e ON a.exam_id = e.id 
        JOIN room r ON r.id = '$room_id'
        WHERE a.id = '$allot_id'
        LIMIT 1";
$res_allot = $conn->query($sql);
$allot = $res_allot->fetch_assoc();

// Fetch all students in this room for this allotment
$sql_students = "SELECT s.id, s.sfname, s.slname, asod.stud_id 
                 FROM allot_student asod
                 JOIN tbl_student s ON asod.student_id = s.id
                 WHERE asod.allot_id = '$allot_id' AND asod.room_id = '$room_id'
                 ORDER BY asod.id ASC";
$res_students = $conn->query($sql_students);
$students = [];
while($s = $res_students->fetch_assoc()) {
    $students[] = $s;
}

$strength = (int)$allot['strength'];
$cols = 6;
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Exam Seating Map</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">View My Seat</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 class="card-title"><?php echo $allot['exam_name']; ?></h4>
                    <p class="text-vibrant">Room: <?php echo $allot['room_name']; ?> | Total Seats: <?php echo $strength; ?></p>
                </div>

                <div class="seating-container">
                    <div class="text-center mb-5">
                        <div style="background: rgba(0,0,0,0.7); color: #fff; padding: 15px; border-radius: 10px; width: 50%; margin: 0 auto; border: 1px solid #444;">
                            <i class="fa fa-desktop"></i> EXAM BOARD / SCREEN
                        </div>
                    </div>

                    <div class="seating-grid" style="grid-template-columns: repeat(<?php echo $cols; ?>, 60px);">
                        <?php
                        for ($i = 0; $i < $strength; $i++) {
                            $is_occupied = isset($students[$i]);
                            $student = $is_occupied ? $students[$i] : null;
                            $is_me = ($is_occupied && $student['id'] == $my_id);
                            
                            $class = $is_occupied ? 'occupied' : '';
                            if ($is_me) $class .= ' highlight';
                            ?>
                            <div class="seat <?php echo $class; ?>">
                                <div class="seat-number"><?php echo $i + 1; ?></div>
                                <i class="fa <?php echo $is_me ? 'fa-star' : 'fa-user'; ?>"></i>
                                <?php if ($is_occupied): ?>
                                    <div class="student-info">
                                        <strong><?php echo $student['stud_id']; ?></strong><br>
                                        <?php echo ($is_me) ? "YOU ARE HERE" : $student['sfname'] . ' ' . $student['slname']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="room-legend" style="margin-top: 50px;">
                        <div class="legend-item">
                            <div class="legend-box" style="background: #FFD700; border: 2px solid #fff;"></div>
                            <span style="font-weight: bold; color: #FFD700;">Your Seat</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-box" style="background: #2196F3;"></div>
                            <span>Other Students</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-box" style="background: #e0e0e0;"></div>
                            <span>Available</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button onclick="window.print();" class="btn btn-dark"><i class="fa fa-print"></i> Print Seating Memo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
