<?php
// Include the database configuration file
date_default_timezone_set("Asia/Manila");
$today = date("m-d-Y H:i:s");
include 'dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
$fname = $_POST['fname'];
$status = "pending";
$manager_code = $_POST['manager_code'];
if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into tallysheet (full_name,manager_code,file_name, date_uploaded,status,extra_field) VALUES ('".$fname."', '".$manager_code."','".$fileName."','".$today."','".$status."','')");
            if($insert){
              


                echo '<script type="text/JavaScript"> 
                        alert("Success Upload");
                        location.replace("index.php");
                     </script>';

            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>