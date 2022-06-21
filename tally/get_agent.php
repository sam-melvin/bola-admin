<?php
session_start();
include 'dbConfig.php';
$userType = "doctor";
$sql = "SELECT `id`,`full_name`,`last_name`,`type_doc` FROM `appoint_users` WHERE `user_type`='$userType'";
if($result=mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0){
        echo '<option value="">Select Doctor</option>';
        while($row = mysqli_fetch_array($result)){
                $doc_name = $row['first_name']."-".$row['last_name'];
                echo '<option value='.$row['id'].'>'.$row['type_doc'].": Dr&#46;" .$doc_name.'</option>';
            
        
        } 
        mysqli_free_result($result);
    }else{
        echo "error";
    }
} 

    
?>