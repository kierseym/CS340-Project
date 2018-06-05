<?php
  session_start();
?>
<?php
  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
  }
  else{
    $user = '';
  }
?>
<!DOCTYPE html>

<?php $currentpage="Profile";
      include "pages.php";
?>

<html>
	<head>
		<title>Profile</title>
		<link rel="stylesheet" href="index.css">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
  include "header.php";
  $msg = "Phofile";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
?>
<h2>Profile info and favorited restaurants will go here.</h2>
<?php
  echo $_SESSION['user'];
 ?>
</body>
</html>
