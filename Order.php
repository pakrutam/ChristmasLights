<?php include("config.php");?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Christmas Lights Shop - Orders</title>
  <meta name="description" content="Christmas Lights Shop">
  <meta name="author" content="SitePoint">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
  <!-- Latest compiled and minified CSS -->
 <script src="js/jquery-1.10.2.js"></script>
 <script src="js/typeahead.js"></script>
 <script>
       $(document).ready(function() {
//Check when Enter is click in Insert Name input and give new values depending on Input
         $('input.Name').on('keyup', function (e) {
             if (e.keyCode == 13) {
                 $InputName_Name = $('input.Name').val();
                 window.location = "Order.php?Name="+$InputName_Name;
             }
         });

//by using typeahead library show availale Names from DB
           $('input.Name').typeahead({
               name: 'Name',
               remote: 'Search.php?query=%QUERY'
           });
       })
   </script>

</head>
<body>
  <div id="Order_Screen">
  <div id='Copyright'>
    <a href='Order.php'> ->All Orders<-</a>
  </div>

<?php
//How many entries in one page (pagination)
  $limit = 5;


//Check if page is set
  if (isset($_GET["pg"])) {
    $page  = $_GET["pg"];
  } else {
    $page=1;
    $ord = "Id";
    $by = "asc";
  };

//Check if ordering is set before
  if (isset($_GET["Order"])) {
  $ord=$_GET['Order'];
  switch($ord){
    case "Id":
      $ord = "Id";
      break;
    case "Name":
      $ord = "Name";
      break;
    case "Date":
      $ord = "Date";
      break;
    default:
      $ord = "Id";
      break;
  }
}

//check if group by is set before
  if (isset($_GET["by"])) {
  $by =$_GET['by'];
    switch($by){
      case "asc":
        $by = "ASC";
        break;
      case "desc":
        $by = "DESC";
        break;
      default:
        $by = "ASC";
        break;
    }
  }

//check if Search for a name is used before
    if (isset($_GET["Name"])){
      $Name = $_GET["Name"];
    }else{
      $Name = '';
    }


  if (isset($_GET["by"])) {
    $by =$_GET['by'];
      if ($by == 'asc'){
        $bywhat = "desc";
    } else{
        $bywhat = "asc";
      }
} else{
    $bywhat = "desc";
}

//from which page to show and then to limit results for pagination
  $start_from = ($page-1) * $limit;

  if (isset($_GET["Name"])) {
    $Name = $_GET["Name"];
//getting with name which is set in input field
    $sql = "SELECT * FROM orders WHERE Name LIKE '%".$Name."%' ORDER BY ".$ord." ".$by." LIMIT $start_from, $limit";
}else{
//Getting all values from orders
    $sql = "SELECT * FROM orders ORDER BY ".$ord." ".$by." LIMIT $start_from, $limit";
}

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
//TABLE of RESULTS
echo "<table class='table table-bordered table-striped text-center'>
<thead>
<tr>
<th class='text-center'><a href=Order.php?Order=Id&by=".$bywhat."&Name=".$Name.">Id</a></th>
<th class='text-center'><a href=Order.php?Order=Name&by=".$bywhat."&Name=".$Name.">Name</a>
<input type='text' name='Name' size='15' class='Name' placeholder='Please Enter Name'>
</th>
<th class='text-center'>Email</th>
<th class='text-center'>Phone</th>
<th class='text-center'>Quantity</th>
<th class='text-center'>Comment</th>
<th class='text-center'><a href=Order.php?Order=Date&by=".$bywhat."&Name=".$Name.">Date</a></th>
</tr>
<thead>
<tbody>";
      while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$row["id"]. "</td>";
          echo "<td>".$row["Name"]. "</td>";
          echo "<td>".$row["Email"]. "</td>";
          echo "<td>".$row["Phone"]. "</td>";
          echo "<td>".$row["Quantity"]. "</td>";
          echo "<td>".$row["Comment"]. "</td>";
          echo "<td>".$row["Date"]. "</td>";
      }
echo "</tr></tbody></table>";
  } else {
      echo "<div id='Copyright'><a href=Order.php>No Orders!</a></div>";
  }
  ?>
  <?php

//pagination
  if (isset($_GET["Name"])) {
    $Name = $_GET["Name"];

//if Name is set use this query
  $sql = "SELECT * FROM orders WHERE Name LIKE '%".$Name."%'";
}else{

//query for all values
    $sql = "SELECT * FROM orders";
}
  $result = $conn->query($sql);
  $total_records = $result->num_rows;
  //rounded up value for number counting
  $total_pages = ceil($total_records / $limit);
  $pagLink = "<div class='pg'>";

if (isset($_GET["Order"])) {
  $ord=$_GET['Order'];
}
  if (isset($_GET["by"])) {
  $by =$_GET['by'];
}

for ($i=1; $i<=$total_pages; $i++) {
           if (($i != $page)OR($page == null)) {
             if (isset($_GET["Name"])) {
            $pagLink .= "<a href='Order.php?pg=".$i."&Order=".$ord."&by=".$by."&Name=".$Name."'>".$i."</a>";
          }else{
            $pagLink .= "<a href='Order.php?pg=".$i."&Order=".$ord."&by=".$by."'>".$i."</a>";
          }
           }else{
            $pagLink .= "<a class='active' href='Order.php?pg=".$i."&Order=".$ord."&by=".$by."&Name=".$Name."'>".$i."</a>";
           }
};
//Show page number if only are more than 1 pages
if ($i > 2){
echo $pagLink;
}
echo  "</div>";

?>

</body>
</html>
