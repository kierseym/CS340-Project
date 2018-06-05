<!DOCTYPE html>

<?php $currentpage="Browse Restaurants";
      include "pages.php";
?>

<html>
	<head>
		<title>Browse Restaurants</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>


<?php
  include "header.php";
  $msg = "Browse Restaurants";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }

  // query to select all information from supplier table
  	$query = "SELECT * FROM Restaurants ";
    // Get results from query
    	$result = mysqli_query($conn, $query);
    	if (!$result) {
    		die("Query to show fields from table failed");
    	}
    // get number of columns in table
    //	$fields_num = mysqli_num_fields($result);
    	echo "<h1>Restaurants:</h1>";
    	//echo "<table id='t01' border='1'><tr>";

    	while($row = mysqli_fetch_row($result)) {
    echo"<div class='restaurant'>
        <div class='restaurant-contents'>
          <div class='clearfix'>
			<div class='restaurant-image-container'>
            <img src=$row[6]>
			</div>
          <div class='restaurant-info-container'>
            <a href='#' class='restaurant-title'>$row[0]</a> <span class='restaurant-rating'>Rating: $row[7]</span> <span class='restaurant-city'>$row[3]</span>
          </div>
		  </div>
        </div>
      </div>";
    }

    /* printing table headers
    	for($i=0; $i<$fields_num; $i++) {
    		$field = mysqli_fetch_field($result);
    		echo "<td><b>$field->name</b></td>";
    	}
    	echo "</tr>\n";
    	while($row = mysqli_fetch_row($result)) {
    		echo "<tr>";
    		// $row is array... foreach( .. ) puts every element
    		// of $row to $cell variable
    		foreach($row as $cell)
    			echo "<td>$cell</td>";
    		echo "</tr>\n";
    	}*/

    	mysqli_free_result($result);
    	mysqli_close($conn);
?>

<form method="get" action="addRestaurant.php">
  <button style="display: inline-block" type="submit">Add New Restaurant</button>
</form>

<form method="get" action="addReview.php">
  <button style="display: inline-block" type="submit">Add New Review</button>
</form>

</body>
</html>
