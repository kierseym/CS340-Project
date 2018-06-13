<?php
session_start();
?>

<?php $currentpage="Help";
      include "pages.php";
?>

<?php
  include "header.php";
  $msg = "Home";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }

  mysqli_close($conn);

?>

<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<h2>User Help</h2>
<p>To create an account or log in to an exiting account go to the home page. Once you are logged in you will be able to add new restaurants, review existing restaurants, and favorite restaurants.</p>
<p>To create a review go to the "Browse Restaurants" page or the "Search Restaurants" page then click "Add Review" next to the restaurant you wish to reveiw.</p>
<p>To favorite a restaurance click on the "Add Favorite" button next to the restaurant you wish to review. To see your favorited restaurant go to the "Profile" page where you can see your favorited restaurants and the reviews that you have made.</p>
<p>To see more information and all reviews for a restaurant, go to "Browse Restaurants" then click on a restaurant name.</p>
</body>
