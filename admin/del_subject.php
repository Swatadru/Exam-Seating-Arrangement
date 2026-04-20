<?php
include '../includes/connect.php';


$sql = "DELETE FROM `tbl_subject` WHERE id='".$_GET["id"]."'";
$res = $conn->query($sql) ;
 $_SESSION['success']=' Record Successfully Deleted';
?>
<script>

window.location = "view_subject.php";
</script>

