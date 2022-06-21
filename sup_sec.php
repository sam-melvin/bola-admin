<?php
include 'dbConfig.php';

$sql = "UPDATE supervisor_seq SET id=LAST_INSERT_ID(id+1);";
$sql .= "SELECT LAST_INSERT_ID()";

if (mysqli_multi_query($conn, $sql)) {
    do {
      // Store first result set
      if ($result = mysqli_store_result($conn)) {
        while ($row = mysqli_fetch_row($result)) {
          printf($row[0]);
        }
        mysqli_free_result($result);
      }
      // if there are more result-sets, the print a divider
      if (mysqli_more_results($conn)) {
      }
       //Prepare next result set
    } while (mysqli_next_result($conn));
  }
  
  mysqli_close($conn);
?>