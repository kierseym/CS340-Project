<?php
session_start();
?>

<?php $currentpage="Delete Work";
      include "pages.php";
?>

<html>
	<head>
		<title>Delete Work Experience</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $username = $_SESSION['user'];
  $msg = "Delete Work Experience for $username";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }

  if(!$username){
  echo "<h2>ERROR: You must be logged in to delete work experience.</h2>";
  echo "<p><a href='home.php' class='add-review-button-rest'>Go home to log in</a></p>";
  }
  else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Escape user inputs for security
        $restaurantName = mysqli_real_escape_string($conn, $_POST['restaurantName']);
        $street = mysqli_real_escape_string($conn, $_POST['street']);
        $zip = mysqli_real_escape_string($conn, $_POST['zip']);

        // See if user is already in the table
        		$queryIn = "SELECT * FROM WorksAt where username='$username' and restaurantName = '$restaurantName' and street = '$street' and zip = '$zip'";
        		$resultIn = mysqli_query($conn, $queryIn);
        		if (mysqli_num_rows($resultIn)> 0) {

              // attempt insert query
                $query = "DELETE FROM WorksAt
                          WHERE username = '$username' and restaurantName = '$restaurantName'
                                and street = '$street' and zip = '$zip'";
                if(mysqli_query($conn, $query)){
                  $msg =  "<p>Work experience successfully deleted.</p>";
                } else{
                  echo "ERROR: Could not execute $query. " . mysqli_error($conn);
                }
        		} else {
        			$msg ="<h2>Error: You don't work at that restaurant.</h2>";
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
  <p>
      <label for="restaurantName">Restaurant:</label>
      <?php
      $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $restQuery = "SELECT DISTINCT restaurantName FROM WorksAt WHERE username = '$username'";
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
      $restQuery = "SELECT DISTINCT street FROM WorksAt WHERE username = '$username'";
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
      $restQuery = "SELECT DISTINCT zip FROM WorksAt WHERE username = '$username'";
      $restResult = mysqli_query($conn, $restQuery);

      echo '<select name="zip">';
      while ($row = mysqli_fetch_row($restResult)) {
        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
      }
      echo '</select>';
      ?>
  </p>

      <p>
        <input type = "submit" class="button-style" value = "Submit" />
        <input type = "reset" class="button-style" value = "Clear Form" />
      </p>
</form>
</div>
</body>
</html>
