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
  $username = $_SESSION['user'];
  $msg = "Update Account";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if(!$username){
  echo "<h2>ERROR: You must be logged in to update your profile.</h2>";
  echo "<p><a href='home.php' class='add-review-button-rest'>Go home to log in</a></p>";
  }
  else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Escape user inputs for security
      	//$username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);

        // See if user is already in the table
        		$queryIn = "SELECT * FROM WebUsers where username='$username' ";
        		$resultIn = mysqli_query($conn, $queryIn);
        		if (mysqli_num_rows($resultIn)> 0) {
              // attempt insert query
                $query = "UPDATE WebUsers
                          SET password = '$password', name = '$name',
                            phoneNumber = '$phoneNumber'
                          WHERE username = '$username'";
                if(mysqli_query($conn, $query)){
                  $msg =  "<p>Account successfully updated. Click the link below to add work experience, or go to the Browse Restaurants page to start looking at restaurants. </p>";
                } else{
                  echo "ERROR: Could not execute $query. " . mysqli_error($conn);
                }
        		} else {
        			$msg ="<h2>Error.</h2>";
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
<form method="get" action="deleteWorkExperience.php">
  <button style="display: inline-block" type="submit" id="delete-work" class="button-style">Delete Work Experience</button>
</form>
</div>
</body>
</html>
