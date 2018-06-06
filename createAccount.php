<?php
session_start();
?>

<?php $currentpage="Create";
      include "pages.php";
?>

<html>
	<head>
		<title>Create Account</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $msg = "Create Account";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    	$username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);

      // See if user is already in the table
      		$queryIn = "SELECT * FROM WebUsers where username='$username' ";
      		$resultIn = mysqli_query($conn, $queryIn);
      		if (mysqli_num_rows($resultIn)> 0) {
      			$msg ="<h2>Error: Please choose another username. That one already exists.</h2>";
      		} else {
      		// attempt insert query
      			$query = "INSERT INTO WebUsers (username, password, name, phoneNumber) VALUES ('$username', '$password', '$name', '$phoneNumber')";
      			if(mysqli_query($conn, $query)){
              $_SESSION['user'] = $username;
              $user = $_SESSION['user'];
      				$msg =  "<p>Account successfully created. Click the link below to add work experience, or go to the Browse Restaurants page to start looking at restaurants. </p>";
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
<div class="form-style">
<form method="post" id="addForm">
  <p>
      <label for="userName">Username:</label>
      <input type="text" class="required" name="username" id="username">
  </p>
  <p>
      <label for="password">Password:</label>
      <input type="text" class="required" name="password" id="password">
  </p>
  <p>
      <label for="name">Name:</label>
      <input type="text" class="required" name="name" id="name">
  </p>
  <p>
      <label for="phoneNumber">Phone Number:</label>
      <input type="number" min=1111111111 max = 9999999999 class="required" name="phoneNumber" id="phoneNumber" title="phone number should be numeric">
  </p>

      <p>
        <input type = "submit" class="button-style" value = "Submit" />
        <input type = "reset" class="button-style" value = "Clear Form" />
      </p>
</form>
<form method="get" action="addWork.php">
  <button style="display: inline-block" type="submit" id="add-work" class="button-style">Add Work Experience</button>
</form>
</div>
</body>
</html>
