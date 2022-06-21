<?php
session_start();
include 'dbConfig.php';
$fname = $_POST['fname'];
$upass = $_POST['upass'];
$phone = $_POST['phone'];
$comrate = $_POST['comrate'];
$ids = $_POST['ids'];

    $sql = "UPDATE `bola_users` SET 
    `full_name`='$fname', 
    `password`='$upass', 
    `phone`='$phone', 
    `com_rate`='$comrate' 
    WHERE `id`='$ids'";

    if ($conn->query($sql) === TRUE) {
    echo "success";
    } else {
    echo "error";
    }

$conn->close();
?>