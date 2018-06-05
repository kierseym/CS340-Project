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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Escape user inputs for security
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $rating = mysqli_real_escape_string($conn, $_POST['rating']);
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $city = mysqli_real_escape_string($conn, $_POST['city']);

    // query to select all information from supplier table
    	$query = "SELECT * FROM Restaurants
                WHERE name = '$name' and rating = '$rating'
                      and type = '$type' and city = '$city'";
      // Get results from query
      	$result = mysqli_query($conn, $query);
      	if (!$result) {
      				echo "ERROR: Could not execute $query. " . mysqli_error($conn);
      	}
      // get number of columns in table
      //	$fields_num = mysqli_num_fields($result);
      	echo "<h1>Restaurants:</h1>";
      	//echo "<table id='t01' border='1'><tr>";

      	while($row = mysqli_fetch_row($result)) {
      echo"<div class='restaurant'>
          <div class='restaurant-contents'>
            <div class='restaurant-image-container'>
              <img src=$row[6]>
            </div>
            <div class='restaurant-info-container'>
              <a href='#' class='restaurant-title'>$row[0]</a> <span class='restaurant-rating'>Rating: $row[7]</span> <span class='restaurant-city'>$row[3]</span>
            </div>
          </div>
        </div>";
      }
    }

    	mysqli_free_result($result);
    	mysqli_close($conn);
?>
<section>
  <h2> <?php echo $msg; ?> </h2>

<form method="post" id="addForm">
<fieldset>
<legend>Search:</legend>

  <p>
    <label for='name'>Name: </label>
    <input type='text' name='name' id='name' class='optional'>
  </p>

  <p>
    <label for='rating'>Overall Rating: </label>
    <input type='number' min = 0 max = 5 name='rating' id='rating' class='optional'>
  </p>

  <p>
    <label for='type'>Type: </label>
    <select id='type' class='optional' name='type'>
      <option selected value='*'>Any</option>
      <option>Other</option>
      <option>American</option>
      <option>Barbecue</option>
      <option>Casual Dining</option>
      <option>Fast Food</option>
      <option>Italian</option>
      <option>Mexican</option>
      <option>Northwest</option>
      <option>Pizza</option>
    </select>
  </p>

  <p>
    <label for='city'>City: </label>
    <input type='text' name='city' id='city' class='optional'>
  </p>
</fieldset>

<p>
  <input type = "submit"  value = "Submit" />
  <input type = "reset"  value = "Clear Form" />
</p>

</form>

<form method="get" action="addRestaurant.php">
  <button style="display: inline-block" type="submit">Add New Restaurant</button>
</form>

<form method="get" action="addReview.php">
  <button style="display: inline-block" type="submit">Add New Review</button>
</form>

</body>
</html>
