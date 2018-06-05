<?php
 session_start();

  //echo "Logout Successful ";
  session_destroy();   // Destroys Session
  //header("Location: login.php");
?>

<?php $currentpage="Logout";
      include "pages.php";
?>

<?php
  include "header.php";
  $msg = "Logout";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
    mysqli_close($conn);
  ?>
  <html>
  	<head>
  		<title>Logout Successful</title>
  		<link rel="stylesheet" href="index.css">
  		<script type = "text/javascript"  src = "verifyInput.js" > </script>
  	</head>
  <body>
    <h2>Logout Successful.</h2>
  </body>
  </html>
