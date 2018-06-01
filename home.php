<!DOCTYPE html>

<?php $currentpage="Home";
      include "pages.php";
?>

<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $msg = "Home";
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

        $queryIn = "SELECT * FROM WebUsers where username='$username' AND password='$password'";
    		$resultIn = mysqli_query($conn, $queryIn);
    		if (mysqli_num_rows($resultIn)> 0) {
    			$msg ="<h2>You have successfully logged in!</h2>";
          session_start();
          if(!$_SESSION["name"])
            $_SESSION["name"] = $username;
          else {
            $_SESSION["name"] = $username;
          }
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
  <div id="container">
<div id="loginForm">
<form method="post" id="addForm" action="myProfile.php">

  <p>
      <label for="userName" class="text-form">Username:</label>
      <input type="text" class="text-form" class="required" name="username" id="username">
  </p>
  <p>
      <label for="password" class="text-form">Password:</label>
      <input type="text" class="text-form" class="required" name="password" id="password">
  </p>


      <p>
        <input type = "Submit" class="text-form" value = "Login" />
</form>
<form method="get" action="createAccount.php">
  <button style="display: inline-block" type="submit">Create Account</button>
</form>
</p>
</div>
<div id="about">
  <h3>About us:</h2>
  <p>Our goal is to help people get honest, accurate reviews on local restaurants. Members are able to rate restaurants based on service, food, and cost. Members can also select their favorite restaurants to keep up to date on.   </p>
</div>
</div>

</body>
</html>
