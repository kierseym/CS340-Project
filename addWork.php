<?php
session_start();
?>

<?php $currentpage="Add Work";
      include "pages.php";
?>

<html>
	<head>
		<title>Add Work Experience</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $username = $_SESSION['user'];
  $msg = "Add Work Experience for $username";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Escape user inputs for security
      $restaurantName = mysqli_real_escape_string($conn, $_POST['restaurantName']);
      $street = mysqli_real_escape_string($conn, $_POST['street']);
      $zip = mysqli_real_escape_string($conn, $_POST['zip']);
      $hourlyPay = mysqli_real_escape_string($conn, $_POST['hourlyPay']);
      $startDay = mysqli_real_escape_string($conn, $_POST['startDay']);
      $startMonth = mysqli_real_escape_string($conn, $_POST['startMonth']);
      $startYear = mysqli_real_escape_string($conn, $_POST['startYear']);
      $startDate = $startYear . '-' . $startMonth . '-' . $startDay;

      // See if user is already in the table
      		$queryIn = "SELECT * FROM WorksAt where username='$username' and restaurantName = '$restaurantName' and street = '$street' and zip = '$zip'";
      		$resultIn = mysqli_query($conn, $queryIn);
      		if (mysqli_num_rows($resultIn)> 0) {
      			$msg ="<h2>Error: You are already listed as working at that restaurant.</h2>";
      		} else {
      		// attempt insert query
      			$query = "INSERT INTO WorksAt (username, restaurantName, street, zip, startDate, houlyPay)
                      VALUES ('$username', '$restaurantName', '$street', '$zip', '$startDate', '$hourlyPay')";
      			if(mysqli_query($conn, $query)){
      				$msg =  "<p>Work experience successfully added.</p>";
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
    <div id="loginForm">

<form method="post" id="addForm">
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
      <label for="startDay">Start Day:</label>
      <input type="number" min=1 max = 31 class="required" name="startDay" id="startDay" title="Start day should be numeric and between 1 and 31.">
  </p>
  <p>
      <label for="startMonth">Start Month:</label>
      <input type="number" min=1 max = 12 class="required" name="startMonth" id="startMonth" title="Start month should be numeric and between 1 and 12.">
  </p>
  <p>
      <label for="startYear">Start Year:</label>
      <input type="number" min=0 max = 2018 class="required" name="startYear" id="startYear" title="Start year should be numeric and between 0 and 2018.">
  </p>
  <p>
      <label for="hourlyPay">Hourly Pay:</label>
      <input type="decimal" min=0 max = 40.00 class="required" name="hourlyPay" id="hourlyPay" title="Hourly pay should be numeric. If salaried, please estimate conversion to hourly pay.">
  </p>

      <p>
        <input type = "submit" class="button-style" value = "Submit" />
        <input type = "reset" class="button-style" value = "Clear Form" />
      </p>
</form>
</div>
</body>
</html>
