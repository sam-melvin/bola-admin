<?php
session_start();
include 'dbConfig.php';
if(!isset($_SESSION["uid"])){ 
  header("Location:./");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Manager Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<p align="right"><a href="logout.php">Logout</a>&nbsp;&nbsp;</p>
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110">
					<h2>Manager</h2>
					<table data-vertable="ver1">
						<thead>

							<tr class="row100 head">
								<th class="column100 column1" data-column="column1">Agent Code</th>
								<th class="column100 column2" data-column="column2">Date Uploaded</th>
								<th class="column100 column8" data-column="column8">Tally Sheet</th>
								<th class="column100 column8" data-column="column8">File Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								
				                $idcode = $_SESSION["uname"];
				                $sql = "SELECT * FROM `tallysheet` WHERE `manager_code`='$idcode'";
				                if($result=mysqli_query($conn, $sql)) {
				                    if(mysqli_num_rows($result) > 0){
				                        while($row = mysqli_fetch_array($result)){
				                                $id = $row['id'];
				                                $fname = $row['full_name'];
				                                $file_name = $row['file_name'];
				                                $dateup = $row['date_uploaded'];
							echo "<tr class='row100'>
								<td class='column100 column6' data-column='column1'>".$fname."</td>
								<td class='column100 column7' data-column='column7'>".$dateup."</td>
								<td class='column100 column7' data-column='column7'>".$file_name."</td>
								<td class='column100 column8' data-column='column8'><a href='http://tallysheet.bolaswerte.com/uploads/".$file_name."' target='_blank' style='color:black;text-align: center;' ><u>View</u></a>
								</td>
							</tr>";

							} 
                        mysqli_free_result($result);
                    }else{
                        echo "error";
                    }
                } 
						?>
							
						</tbody>
					</table>
				</div>

				
			</div>
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>