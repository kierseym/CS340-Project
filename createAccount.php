<!DOCTYPE html>

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
  $msg = "Login";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	$username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $hashedpassword = MD5('$password');
    //  echo $hashedpassword;
      //$queryIn = mysql_query("SELECT * FROM Users where username='$username' AND password='MD5($password)'");
      //$resultIn = msqli_query($conn, $queryIn);

        $queryIn = "SELECT * FROM Users where username='$username' AND password=MD5('$password')";
    		$resultIn = mysqli_query($conn, $queryIn);
    		if (mysqli_num_rows($resultIn)> 0) {
    			$msg ="<h2>You have successfully logged in!</h2>";
    		}
        else{
          $msg = "<h2>The username or password you entered are incorrect.</h2>";
        }/*
      if(mysql_fetch_rows()>0) {
      echo "You have succesfully logged in!";
    }
    else{
      echo "The username or password you entered are incorrect.";
    }*/

    }

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
      <label for="password">Password:</label>
      <input type="text" class="required" name="password" id="password">
  </p>
</fieldset>

      <p>
        <input type = "submit"  value = "Submit" />
        <input type = "reset"  value = "Clear Form" />
      </p>
</form>
</body>
</html>
