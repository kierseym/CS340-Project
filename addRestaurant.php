<?php
session_start();
?>

<?php $currentpage="Add Restaurant";
      include "pages.php";
?>

<html>
	<head>
		<title>Add Restaurant</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $msg = "Add Restaurant";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if(!$username){
  echo "<h2>ERROR: You must be logged in to add a restaurant.</h2>";
  echo "<p><a href='home.php' class='add-review-button-rest'>Go home to log in</a></p>";
  }
  else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Escape user inputs for security
      	//$username = mysqli_real_escape_string($conn, $_POST['username']);
        $restaurantName = mysqli_real_escape_string($conn, $_POST['restaurantName']);
        $street = mysqli_real_escape_string($conn, $_POST['street']);
        $zip = mysqli_real_escape_string($conn, $_POST['zip']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $photoURL = mysqli_real_escape_string($conn, $_POST['photoURL']);
        //$rating = ;

        // See if user is already in the table
        		$queryIn = "SELECT * FROM Restaurants where name = '$restaurantName' and street = '$street' and zip = '$zip'";
        		$resultIn = mysqli_query($conn, $queryIn);
        		if (mysqli_num_rows($resultIn)> 0) {
        			$msg ="<h2>Error: That restaurant already exists in the database.</h2>";
        		} else {
        		// attempt insert query
        			$query = "INSERT INTO Restaurants (name, street, zip, city, state, type, photoURL)
                        VALUES ('$restaurantName', '$street', '$zip', '$city', '$state', '$type', '$photoURL')";
        			if(mysqli_query($conn, $query)){
        				$msg =  "<p>Restaurant successfully added.</p>";
        			} else{
        				echo "ERROR: Could not execute $query. " . mysqli_error($conn);
        			}
        		}
        }
      }


// close connection
  mysqli_close($conn);

?>

<section>
  <h2> <?php echo $msg; ?> </h2>

<form method="post" id="addForm">
<fieldset>
<legend>Restaurant Info:</legend>
  <p>
      <label for="restaurantName">Restaurant:</label>
      <input type="text" class="required" name="restaurantName" id="restaurantName">
  </p>
  <p>
      <label for="street">Street Address:</label>
      <input type="text" class="required" name="street" id="street">
  </p>
  <p>
      <label for="zip">Zip Code:</label>
      <input type="number" min=97001 max = 97920 class="required" name="zip" id="zip" title="Zip code should be numeric and in Oregon.">
  </p>
  <p>
      <label for="city">City:</label>
      <input type="text" class="required" name="city" id="city">
  </p>
  <p>
      <label for="state">State:</label>
      <input type="text" class="required" name="state" id="state">
  </p>
  <p>
    <label for="type">Type:</label>
    <select class="required" name="type" id="type">
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
      <label for="photoURL">Photo URL:</label>
      <input type="text" class="required" name="photoURL" id="photoURL">
  </p>

</fieldset>

      <p>
        <input type = "submit"  value = "Submit" />
        <input type = "reset"  value = "Clear Form" />
      </p>
</form>
</body>
</html>
