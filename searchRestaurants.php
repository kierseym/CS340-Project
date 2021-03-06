<!DOCTYPE html>

<?php $currentpage="Search Restaurants";
      include "pages.php";
?>

<html>
	<head>
		<title>Search Restaurants</title>
		<link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $msg = "Search Restaurants";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
?>
<form method="get" action="addRestaurant.php">
  <button class="browse-button-style" type="submit">Add New Restaurant</button>
</form>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $rating = mysqli_real_escape_string($conn, $_POST['rating']);
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $city = mysqli_real_escape_string($conn, $_POST['city']);
      if(!$name && !$rating && !$type && !$city){
          $query = "SELECT * FROM Restaurants";
      }
      elseif(!$name && !$rating && !$type){
        $query = "SELECT * FROM Restaurants
                  WHERE city = '$city'";
      }
      elseif(!$name && !$rating && !$city){
        $query = "SELECT * FROM Restaurants
                  WHERE type = '$type'";
      }
      elseif(!$name && !$type && !$city){
        $query = "SELECT * FROM Restaurants
                  WHERE rating = '$rating'";
      }
      elseif(!$type && !$rating && !$city){
        $query = "SELECT * FROM Restaurants
                  WHERE name = '$name'";
      }
      elseif(!$name && !$rating){
        $query = "SELECT * FROM Restaurants
                  WHERE city = '$city' and type = '$type'";
      }
      elseif(!$name && !$type){
        $query = "SELECT * FROM Restaurants
                  WHERE city = '$city' and rating = '$rating'";
      }
      elseif(!$name && !$city){
        $query = "SELECT * FROM Restaurants
                  WHERE rating = '$rating' and type = '$type'";
      }
      elseif(!$rating && !$city){
        $query = "SELECT * FROM Restaurants
                  WHERE name = '$name' and type = '$type'";
      }
      elseif(!$rating && !$type){
        $query = "SELECT * FROM Restaurants
                  WHERE name = '$name' and city = '$city'";
      }
      elseif(!$city && !$type){
        $query = "SELECT * FROM Restaurants
                  WHERE name = '$name' and rating = '$rating'";
      }
      elseif(!$city){
        $query = "SELECT * FROM Restaurants
                  WHERE name = '$name' and type = '$type'
                        and rating = '$rating'";
      }
      elseif(!$name){
        $query = "SELECT * FROM Restaurants
                  WHERE city = '$city' and type = '$type'
                        and rating = '$rating'";
      }
      elseif(!$rating){
        $query = "SELECT * FROM Restaurants
                  WHERE city = '$city' and type = '$type'
                        and name = '$name'";
      }
      elseif(!$type){
        $query = "SELECT * FROM Restaurants
                  WHERE city = '$city' and rating = '$rating'
                        and name = '$name'";
      }
      else{
      	$query = "SELECT * FROM Restaurants
                  WHERE name = '$name' and rating = '$rating'
                        and type = '$type' and city = '$city'";
      }
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
                      <div class='clearfix'>
              <div class='restaurant-image-container'>
                <img src=$row[6]>
              </div>
              <div class='restaurant-info-container'>
                <a href='restaurant.php?restName=$row[0]' class='restaurant-title-browse'>$row[0]</a> <span class='restaurant-rating'>Rating: $row[7]</span> <span class='restaurant-city'>$row[3]</span>
                <a href='addReview.php?restName=$row[0]&zip=$row[2]&street=$row[1]' class='add-review-button' id='searchRest'>Add Review</a>
                <a href='addFavorite.php?restName=$row[0]&zip=$row[2]&street=$row[1]' class='add-review-button' id='browseRest'>Add Favorite</a>
              </div>
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
    <input type='text' name='rating' id='rating' class='optional'title="rating should be numeric and between 0 and 5">
  </p>

  <p>
    <label for='type'>Type: </label>
    <select id='type' class='optional' name='type'>
      <option selected value=''>Any</option>
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
<p>
  <input type = "submit"  value = "Submit" />
</p>
</fieldset>

</form>

</body>
</html>
