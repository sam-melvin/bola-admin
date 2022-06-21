<?php
session_start();
include("../../../backend/connect.php");

$apid = $_GET['id'];
$sql = "UPDATE `appointments` SET `appoint_status`='Pending' WHERE id='$apid'";
if(mysqli_query($conn, $sql)){
    $_SESSION["uptappoint"] = "success";
} else {
    $_SESSION["uptappoint"] = "error";
}

echo "<script>location.replace('approve_table.php');</script>"
?>