<?php include('../includes/head.php');?>
<?php include('../includes/header.php');?>
<?php include('../includes/sidebar.php');?>
<link rel="stylesheet" href="../assets/css/seating.css">

<?php
include('../includes/connect.php');

if(!isset($_GET['id'])) {
    echo "<script>location.href='view_allotment.php';</script>";
    exit;
}

$allot_id = $_GET['id'];

// Fetch Allotment details
$sql = "SELECT a.*, e.name as exam_name, r.name as room_name, r.strength, r.id as room_id 
        FROM allot a 
        JOIN exam e ON a.exam_id = e.id 
        JOIN allot_student asod ON a.id = asod.allot_id
        JOIN room r ON asod.room_id = r.id
        WHERE a.id = '$allot_id'
        LIMIT 1";
$res_allot = $conn->query($sql);
$allot = $res_allot->fetch_assoc();

if (!$allot) {
    echo "<div class='page-wrapper'><div class='container-fluid'><h3>No data found for this allotment.</h3></div></div>";
    include('../includes/footer.php');
    exit;
}

// Fetch all students in this room for this allotment
$sql_students = "SELECT s.sfname, s.slname, asod.stud_id 
                 FROM allot_student asod
                 JOIN tbl_student s ON asod.student_id = s.id
                 WHERE asod.allot_id = '$allot_id' AND asod.room_id = '".$allot['room_id']."'
                 ORDER BY asod.id ASC";
$res_students = $conn->query($sql_students);
$students = [];
while($s = $res_students->fetch_assoc()) {
    $students[] = $s;
}

$strength = (int)$allot['strength'];
$cols = 6;
$rows = ceil($strength / $cols);
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Room Seating Structure</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="view_allotment.php">Allotments</a></li>
                <li class="breadcrumb-item active">Seating Map</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 class="card-title"><?php echo $allot['room_name']; ?> - <?php echo $allot['exam_name']; ?></h4>
                    <p class="text-muted">Total Capacity: <?php echo $strength; ?> | Students Allotted: <?php echo count($students); ?></p>
                </div>

                <div class="seating-container">
                    <div class="text-center mb-3">
                        <div style="background: #333; color: #fff; padding: 10px; border-radius: 5px; width: 60%; margin: 0 auto; margin-bottom: 20px;">
                            EXAM TABLE / STAGE
                        </div>
                    </div>

                    <div class="seating-grid" style="grid-template-columns: repeat(<?php echo $cols; ?>, 60px);">
                        <?php
                        for ($i = 0; $i < $strength; $i++) {
                            $is_occupied = isset($students[$i]);
                            $student = $is_occupied ? $students[$i] : null;
                            $class = $is_occupied ? 'occupied' : '';
                            ?>
                            <div class="seat <?php echo $class; ?>">
                                <div class="seat-number"><?php echo $i + 1; ?></div>
                                <i class="fa fa-user"></i>
                                <?php if ($is_occupied): ?>
                                    <div class="student-info">
                                        <strong><?php echo $student['stud_id']; ?></strong><br>
                                        <?php echo $student['sfname'] . ' ' . $student['slname']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="room-legend">
                        <div class="legend-item">
                            <div class="legend-box" style="background: #2196F3;"></div>
                            <span>Occupied</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-box" style="background: #e0e0e0;"></div>
                            <span>Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
