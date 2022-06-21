<?php
session_start();
include("../../../backend/connect.php");

$doc_email = $_POST['doc_email'];
$doc_pass = $_POST['doc_pass'];
$doc_fname = $_POST['doc_fname'];
$doc_lname = $_POST['doc_lname'];
$doc_clinic = $_POST['doc_clinic'];
$doc_type = $_POST['doc_type'];
$doc_est_patient = $_POST['doc_est_patient'];
$doc_sced = $_POST['doc_sced'];
$curdate = date("m/d/Y");
$doc_assign = $_POST['assign_doc'];
echo "doc assign: ".$doc_assign;
$keys = $doc_email." ".$doc_pass." ".$doc_fname." ".$doc_lname." ".$doc_clinic." ".$doc_type." ".$doc_est_patient." ".$doc_sced." ".$password; 
$sql = "INSERT INTO `appoint_users`(`email`, `password`, `first_name`, `last_name`, `type_doc`, `clinic`, `est_no_patient`, `schedule`, `user_type`, `assigned_doc`,`date_registered`, `Keywords`) 
VALUES ('$doc_email','$doc_pass','$doc_fname','$doc_lname','$doc_type','$doc_clinic','$doc_est_patient','$doc_sced','$userType', '$doc_assign','$curdate','$keys')";
if (mysqli_query($conn, $sql)) {
    $_SESSION["reg_doc"] = "success";
} 
else {
    $_SESSION["reg_doc"] = "error";
}
mysqli_close($conn);

// echo "<script>location.replace('regdoc_form.php');</script>"
?>