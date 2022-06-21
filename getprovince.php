<?php
session_start();
include 'dbConfig.php';
// $ids = $_POST['ids'];
$sql = "SELECT * FROM `province` WHERE `country_id`='174' ORDER BY `province` ASC ";
echo "<option value=''>--SELECT</option>";
if($result=mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0){
        
        while($row = mysqli_fetch_array($result)){
            $ids = $row['id'];
            $province = $row['province'];
                 echo "<option value='$ids'>$province</option>";
        } 
        mysqli_free_result($result);
    }else{
        echo "error";
    }
} 

    