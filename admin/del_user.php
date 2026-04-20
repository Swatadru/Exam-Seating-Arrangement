<?php
include '../includes/connect.php';


$sql = "DELETE FROM admin WHERE id='".$_GET["id"]."'";
$res = $conn->query($sql) ;
 $_SESSION['success']=' Record Successfully Deleted';
?>
<script>

window.location = "view_user.php";
</script>

