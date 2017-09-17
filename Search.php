<?php
//Fow autocomplete seach in input Name field
include("config.php");
if(isset($_REQUEST['query'])){
$query = $_REQUEST['query'];
 $sql = "SELECT Name FROM orders WHERE Name LIKE '%{$query}%'";
 $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
         $data[] = array (
           'label' => $row['Name'],
           'value' => $row['Name'],
         );
     }
    echo json_encode($data);
  }
?>
