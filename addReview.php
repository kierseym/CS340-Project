<!DOCTYPE html>

<?php $currentpage="Add Review";
      include "pages.php";
?>

<html>
	<head>
		<title>Add Review</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $msg = "Add Review";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Escape user inputs for security
    	$username = mysqli_real_escape_string($conn, $_POST['username']);
      $restaurantName = mysqli_real_escape_string($conn, $_POST['restaurantName']);
      $street = mysqli_real_escape_string($conn, $_POST['street']);
      $zip = mysqli_real_escape_string($conn, $_POST['zip']);
      $review = mysqli_real_escape_string($conn, $_POST['review']);
      $serviceRating = mysqli_real_escape_string($conn, $_POST['serviceRating']);
      $foodRating = mysqli_real_escape_string($conn, $_POST['foodRating']);
      $costRating = mysqli_real_escape_string($conn, $_POST['costRating']);
      $overallRating = ($serviceRating + $foodRating + $costRating)/3.00;

      // See if user is already in the table
      		$queryIn = "SELECT * FROM Review where username='$username' and restaurantName = '$restaurantName' and street = '$street' and zip = '$zip'";
      		$resultIn = mysqli_query($conn, $queryIn);
      		if (mysqli_num_rows($resultIn)> 0) {
            // attempt UPDATE query
        			$query = "UPDATE Review
                        SET overallRating = '$overallRating', review = '$review',
                          serviceRating = '$serviceRating', foodRating = '$foodRating',
                          costRating = '$costRating'
                        WHERE username = '$username' and restaurantName = '$restaurantName' and
                           street = '$street' and zip = '$zip'";
      			if(mysqli_query($conn, $query)){
      			     $msg ="<h2>You have successfully updated your review.</h2>";
            } else{
              echo "ERROR: Could not execute $query. " . mysqli_error($conn);
            }
      		} else {
      		// attempt insert query
      			$query = "INSERT INTO Review (username, restaurantName, street, zip, overallRating, review, serviceRating, foodRating, costRating)
                      VALUES ('$username', '$restaurantName', '$street', '$zip', '$overallRating', '$review', '$serviceRating', '$foodRating', '$costRating')";
      			if(mysqli_query($conn, $query)){
      				$msg =  "<p>Review successfully added.</p>";
      			} else{
      				echo "ERROR: Could not execute $query. " . mysqli_error($conn);
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
<legend>User Restaurant Review Info:</legend>
  <p>
      <label for="userName">Username:</label>
      <input type="text" class="required" name="username" id="username">
  </p>

  <p>
      <label for="restaurantName">Restaurant:</label>
      <?php
      $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $restQuery = "SELECT DISTINCT name FROM Restaurants WHERE 1";
      $restResult = mysqli_query($conn, $restQuery);

      echo '<select name="restaurantName">';
      while ($row = mysqli_fetch_row($restResult)) {
        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
      }
      echo '</select>';
      ?>
  </p>
  <p>
      <label for="street">Street Address:</label>
      <?php
      $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $restQuery = "SELECT DISTINCT street FROM Restaurants WHERE 1";
      $restResult = mysqli_query($conn, $restQuery);

      echo '<select name="street">';
      while ($row = mysqli_fetch_row($restResult)) {
        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
      }
      echo '</select>';
      ?>
  </p>
  <p>
      <label for="zip">Zip Code:</label>
      <?php
      $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $restQuery = "SELECT DISTINCT zip FROM Restaurants WHERE 1";
      $restResult = mysqli_query($conn, $restQuery);

      echo '<select name="zip">';
      while ($row = mysqli_fetch_row($restResult)) {
        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
      }
      echo '</select>';
      ?>
  </p>
  <p>
      <label for="review">Comments:</label>
      <input type="text" class="required" name="review" id="review">
  </p>
  <p>
    <label for="serviceRating">Service Rating:</label>
    <select class="required" name="serviceRating" id="serviceRating">
      <option>0</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </p>
  <p>
    <label for="foodRating">Food Rating:</label>
    <select class="required" name="foodRating" id="foodRating">
      <option>0</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </p>
  <p>
    <label for="costRating">Cost Rating:</label>
    <select class="required" name="costRating" id="costRating">
      <option>0</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </p>
</fieldset>

      <p>
        <input type = "submit"  value = "Submit" />
        <input type = "reset"  value = "Clear Form" />
      </p>
</form>
</body>
</html>
