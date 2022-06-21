<?php
session_start();
include 'dbConfig.php';
$ids = $_POST['ids'];
$sql = "SELECT `bet_numbers` FROM `digital_tally` WHERE `id`='$ids'";
if($result=mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0){
        
        while($row = mysqli_fetch_array($result)){
            $bets = json_decode($row['bet_numbers']);

              foreach ($bets as $value) {
                echo '<tr>';
                echo '<td>'.$value->betnumber.'</td>';
                echo '<td>'.$value->straight.'</td>';
                echo '<td>'.$value->rumbled.'</td>';
                 echo '</tr>';
              }
            
        } 
        mysqli_free_result($result);
    }else{
        echo "error";
    }
} 

    
?>