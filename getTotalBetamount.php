<?php
session_start();
include 'dbConfig.php';
$draw_id = $_POST['draw_id'];
$sql = "SELECT * FROM `bets` WHERE `draw_id` = '$draw_id' AND `status` = 'pending'";
$total_amount = 0;
if($result=mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0){
        
        while($row = mysqli_fetch_array($result)){
            
            $amount = $row['amount'];
                //  echo "<option value='$ids'>$province</option>";

            $total_amount += (float)$row['amount'];
        } 
        mysqli_free_result($result);
    }else{
        
    }
} 

echo  $total_amount;
?>