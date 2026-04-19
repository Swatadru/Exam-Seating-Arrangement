<?php
date_default_timezone_set('Asia/Kolkata');
include('../../includes/connect.php');
include('../../includes/functions.php');

if(isset($_POST['btn_save'])) {
    $class_id = $_POST['class_id'];
    $room_type_id = $_POST['room_type_id'];
    $subject_id = $_POST['subject_id'];
    $exam_id = $_POST['exam_id'];
    $added_date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO `allot` (`class_id`, `room_type_id`, `subject_id`, `exam_id`, `added_date`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $class_id, $room_type_id, $subject_id, $exam_id, $added_date);
    
    if ($stmt->execute()) {
        $last_allot_id = $conn->insert_id;
        
        $stmt_exam = $conn->prepare("SELECT exam_date, start_time, end_time FROM `exam` WHERE id = ?");
        $stmt_exam->bind_param("s", $exam_id);
        $stmt_exam->execute();
        $exam_res = $stmt_exam->get_result()->fetch_assoc();
        
        $stmt_students = $conn->prepare("SELECT id, stud_id FROM `tbl_student` WHERE classname = ? ORDER BY id ASC");
        $stmt_students->bind_param("s", $class_id);
        $stmt_students->execute();
        $student_result = $stmt_students->get_result();
        $students = [];
        while($s = $student_result->fetch_assoc()) {
            $students[] = $s;
        }

        $stmt_rooms = $conn->prepare("SELECT id, strength FROM `room` WHERE type_id = ? ORDER BY id ASC");
        $stmt_rooms->bind_param("s", $room_type_id);
        $stmt_rooms->execute();
        $room_result = $stmt_rooms->get_result();
        
        $student_index = 0;
        $total_students = count($students);

        while ($room = $room_result->fetch_assoc()) {
            $room_id = $room['id'];
            $room_strength = $room['strength'];
            
            for ($i = 0; $i < $room_strength && $student_index < $total_students; $i++) {
                $student = $students[$student_index];
                $student_db_id = $student['id'];
                $stud_id_val = $student['stud_id'];
                
                $stmt_check = $conn->prepare("SELECT id FROM `allot_student` WHERE exam_id = ? AND student_id = ?");
                $stmt_check->bind_param("ss", $exam_id, $student_db_id);
                $stmt_check->execute();
                if ($stmt_check->get_result()->num_rows == 0) {
                    $stmt_insert = $conn->prepare("INSERT INTO `allot_student`(`allot_id`, `exam_id`, `exam_date`, `start_time`, `end_time`, `room_id`, `student_id`, `stud_id`, `teacher_id`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt_insert->bind_param("sssssssss", 
                        $last_allot_id, 
                        $exam_id, 
                        $exam_res['exam_date'], 
                        $exam_res['start_time'], 
                        $exam_res['end_time'], 
                        $room_id, 
                        $student_db_id, 
                        $stud_id_val,
                        $_POST['teacher_id']
                    );
                    $stmt_insert->execute();
                }
                $student_index++;
            }
            
            if ($student_index >= $total_students) break;
        }

        $_SESSION['success'] = 'Record Successfully Added';
    } else {
        $_SESSION['error'] = 'Something Went Wrong: ' . $conn->error;
    }
}

header("Location: ../view_allotment.php");
exit();
?>
