<?php
session_start();
include 'dbConfig.php';
$ids = $_POST['ids'];

$sql = "DELETE FROM `bola_users` WHERE id=$ids";

    if ($conn->query($sql) === TRUE) {
    echo "success";
    } else {
    echo "error";
    }

$conn->close();
?>