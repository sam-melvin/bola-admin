<?php
session_start();
include 'dbConfig.php';
$ids = $_POST['ids'];
$sql = "SELECT `digit_2` FROM `digital_tally` WHERE `id`='$ids'";
if($result=mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0){
        
        while($row = mysqli_fetch_array($result)){
            $bets = json_decode($row['digit_2']);
            
              
              if($bets == null){
                echo '<tr>';
                echo '<td> No bets</td>';
                echo '<td>0</td>';
                 echo '</tr>';
                }
                else {
                    foreach ($bets as $value) {
                        echo '<tr>';
                        echo '<td>'.$value->betnumber.'</td>';
                        echo '<td>'.$value->bet.'</td>';
                         echo '</tr>';
                      }
        
                }
            
        } 
        mysqli_free_result($result);
    }else{
        echo "error";
    }
} 

    
?>