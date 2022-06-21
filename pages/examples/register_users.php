<?php
session_start();
include("../../../backend/connect.php");
if(isset($_POST['reguser_btn']))
{
    $user_email = $_POST['user_email'];
    $user_pass = $_POST['user_pass'];
    $user_fname = $_POST['user_fname'];
    $user_lname = $_POST['user_lname'];
    $doc_assign = $_POST['assign_doc'];
    if($doc_assign != 0)
        $usertype = "secretary";
    else
        $usertype = "admin";

    $curdate = date("m/d/Y");
    echo "doc assign: ".$doc_assign;
    $keys = $user_email." ".$user_pass." ".$user_fname." ".$user_lname." ".$doc_assign; 
    $sql = "INSERT INTO `appoint_users`(`email`, `password`, `first_name`, `last_name`,`user_type`, `assigned_doc`, `date_registered`, `Keywords`) 
    VALUES ('$user_email','$user_pass','$user_fname','$user_lname','$usertype','$doc_assign','$curdate','$keys')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION["reg_doc"] = "success";
    } 
    else {
        $_SESSION["reg_doc"] = "error";
    }
    mysqli_close($conn);
}
    

echo "<script>location.replace('reg_users.php');</script>"
?>