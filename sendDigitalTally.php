<?php
session_start();
include 'dbConfig.php';
if(isset($_POST['btnSend'])){
    $status = "sent";
    $isSuper = false;
    $sql = '';
    if($_SESSION["utype"] == "supervisor"){
        $status = "process";
        $isSuper = true;
    }
    else if($_SESSION["utype"] == "manager"){
        $status = "sent";
    }

    $rate = $_SESSION["com_rate"];
    $sendArray = $_POST['sendPayArray'];
    $assign_id = $_SESSION["assign_id"];
    $array = json_decode($sendArray);
    $cnt = count($array);
    echo "<br/>";
    $markIds = implode(",",  $_POST['tally']);
    if($isSuper) {
        $sql = "UPDATE `digital_tally` SET `grand_total_sup` = CASE ";
    }
    else {
        $sql = "UPDATE `digital_tally` SET `grand_total_man` = CASE ";
    }
    
    for ($c = 0; $c < $cnt; $c++) {
        $obj = json_decode($array[$c]);
        $uid = $obj->{'id'};
        $totalpayout = $obj->{'total_payout'};

        $sql .= "WHEN `id` = '$uid' then '$totalpayout' ";
     }
     if($isSuper) {
        $sql .= " ELSE `grand_total_sup` ";
    } else {
        $sql .= " ELSE `grand_total_man` ";
    }
     $sql .= " END, ";
     $sql .= " `status` = '$status', ";
     if($isSuper){
        $sql .= " `assign_man_code` = '$assign_id', ";
        $sql .= " `com_percent_sup` = '$rate' ";
     }
     else {
        $sql .= " `com_percent_man` = '$rate' ";
     }
     
     $sql .= " WHERE `id` IN ($markIds)";
    
    // $sql = "UPDATE `digital_tally` SET `status`='$status' WHERE id IN ($markIds)";
    if(mysqli_query($conn, $sql)){
        $_SESSION["uptappoint"] = "success";
    } else {
        $_SESSION["uptappoint"] = "error";
    }
    echo "<script>location.replace('./');</script>";
    
}


?>