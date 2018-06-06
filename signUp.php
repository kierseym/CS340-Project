<!DOCTYPE html>
<!-- Add User Info to Table Supplier -->
<?php
		$currentpage="Sign Up";
		include "pages.php";



?>
<html>
	<head>
		<title>Sign Up</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
	include "header.php";
	$msg = "Sign Up";

// change the value of $dbuser and $dbpass to your username and password
	include 'connectvars.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Escape user inputs for security
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
		$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$age = mysqli_real_escape_string($conn, $_POST['age']);


// See if user is already in the table
		$queryIn = "SELECT * FROM Users where username='$username' ";
		$resultIn = mysqli_query($conn, $queryIn);
		if (mysqli_num_rows($resultIn)> 0) {
			$msg ="<h2>User already exists</h2>";
		} else {

		// attempt insert query

			$query = "INSERT INTO Users (username, firstName, lastName, email, password, age) VALUES ('$username', '$firstName', '$lastName', '$email', MD5('$password'), '$age')";
			if(mysqli_query($conn, $query)){
				$msg =  "<p>Record added successfully.</p>";
			} else{
				echo "ERROR: Could not able to execute $query. " . mysqli_error($conn);
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
	<legend>User Info:</legend>
    <p>
        <label for="userName">Username:</label>
				<input type="text" class="required" name="username" id="username">
    </p>
    <p>
        <label for="firstName">First name:</label>
        <input type="text" class="required" name="firstName" id="firstName">
    </p>

    <p>
        <label for="lastName">Last name:</label>
        <input type="text" class="required" name="lastName" id="lastName">
		</p>
		<p>
        <label for="password">Password:</label>
        <input type="text" class="required" name="password" id="password">
		</p>
		<p>
				<label for="email">Email:</label>
				<input type="text" class="required" name="email" id="email">
		</p>
		<p>
				<label for="age">Age:</label>
				<input type="number" min=1 max = 99999 class="optional" name="age" id="age" title="age should be numeric">
		</p>
</fieldset>

      <p>
        <input type = "submit"  value = "Submit" />
        <input type = "reset"  value = "Clear Form" />
      </p>
</form>
</body>
</html>
