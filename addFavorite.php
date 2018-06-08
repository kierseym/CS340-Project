<?php
session_start();
?>

<?php $currentpage="Add Favorite";
      include "pages.php";
?>

<html>
	<head>
		<title>Add Favorite</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $username = $_SESSION['user'];
  $msg = "Add Favorite for $username";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if(!$username){
  echo "<h2>ERROR: You must be logged in to favorite a restaurant.</h2>";
  echo "<p><a href='home.php' class='add-review-button-rest'>Go home to log in</a></p>";
  }
  else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Escape user inputs for security
      	//$username = mysqli_real_escape_string($conn, $_POST['username']);
      //  $restaurantName = mysqli_real_escape_string($conn, $_POST['restaurantName']);
        //$street = mysqli_real_escape_string($conn, $_POST['street']);
        //$zip = mysqli_real_escape_string($conn, $_POST['zip']);
        $restaurantName = $_GET['restName'];
        $zip = $_GET['zip'];
        $street = $_GET['street'];

        // See if user is already in the table
        		$queryIn = "SELECT * FROM Favorite where username='$username' and restaurantName = '$restaurantName' and street = '$street' and zip = '$zip'";
        		$resultIn = mysqli_query($conn, $queryIn);
        		if (mysqli_num_rows($resultIn)> 0) {
                echo "ERROR: You have already favorited that restaurant.";
        		} else {
        		// attempt insert query
        			$query = "INSERT INTO Favorite (username, restaurantName, street, zip)
                        VALUES ('$username', '$restaurantName', '$street', '$zip')";
        			if(mysqli_query($conn, $query)){
        				$msg =  "<p>Favorite successfully added.</p>";
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
<div id="loginForm">
<form method="post" id="addForm">

<!--
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
-->
  <?php
    $restName = $_GET['restName'];
    echo "      <p>
            <input type = 'submit' class='button-style' value = 'Confirm Favorite for $restName' />
          </p>";
  ?>



</form>
</div>
</body>
</html>
