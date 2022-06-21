<?php
session_start();
include("../../../backend/connect.php");

$apid = $_GET['id'];
$sql = "UPDATE `appointments` SET `appoint_status`='Approved' WHERE id='$apid'";
if(mysqli_query($conn, $sql)){
    $_SESSION["uptappoint"] = "success";
} else {
    $_SESSION["uptappoint"] = "error";
}


$sql2 = "SELECT * FROM `appointments` WHERE id='$apid'";
         if($result2=mysqli_query($conn, $sql2)) {
                    if(mysqli_num_rows($result2) > 0){
                        while($row2 = mysqli_fetch_array($result2)){
                                $emails= $row2['appoint_email'];
                                $apdate= $row2['appoint_date'];
                                $aptime= $row2['appoint_time'];
                        }
                    }
                }
$getDateTime = $apdate." ".$aptime;
$apdatetime = date_create($getDateTime);                        
$senddatetime = date_format($apdatetime,"F j, Y g:i a");
$getsubject = "Approved appointment";
$getmessage = "The request of your appointment on ".$senddatetime." have been approved";
include("../../../mail1.php");
echo "<script>location.replace('patient_table.php');</script>"

?>