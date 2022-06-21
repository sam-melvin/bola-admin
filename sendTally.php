<?php
session_start();
include 'dbConfig.php';
if(isset($_POST['btnSend'])){

$apid = $_GET['id'];
$markIds = implode(",",  $_POST['tally']);
$sql = "UPDATE `tallysheet` SET `status`='sent' WHERE id IN ($markIds)";
if(mysqli_query($conn, $sql)){
    $_SESSION["uptappoint"] = "success";
} else {
    $_SESSION["uptappoint"] = "error";
}

echo "<script>location.replace('./');</script>";
    
}


?>