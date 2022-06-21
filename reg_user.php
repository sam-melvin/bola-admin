<?php
session_start();
include 'dbConfig.php';
if(isset($_POST['reguser_btn']))
{   
    $utype = $_SESSION["utype"];
    $id_code = $_POST['id_code'];
    $apass = $_POST['apass'];
    $fname = $_POST['fname'];
    $atype = 'supervisor';
    
    if($utype == 'supervisor')
        $atype = 'agent';

    $aphone = $_POST['aphone'];
    $com_rate = $_POST['com_rate'];
    $assign_id = $_SESSION["ucode"];
    $seq_num = $_POST['seq_num'];
    // $curdate = date("m/d/Y");
    $sql = "INSERT INTO `bola_users`(`assign_id`,`user_id_code`,`full_name`,`password`,`com_rate`,`type`,`phone`,`seq_num`) 
    VALUES ('$assign_id','$id_code','$fname','$apass','$com_rate ','$atype','$aphone','$seq_num')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Register Success');
        </script>";
    } 
    else {
        echo "<script>
        alert('Error Occured!');
        </script>";
    }
    mysqli_close($conn);
}
    

echo "<script>

location.replace('reg_agent.php');</script>";
?>