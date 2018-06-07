<?php
session_start();
?>

<?php $currentpage="Browse Restaurants";
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

?>

<?php
  $restName = $_GET["restName"];
?>

<html>
	<head>
		<title><?php echo $restName; ?></title>
		<link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<script type = "text/javascript"  src = "verifyInput.js" > </script>
	</head>
<body>

<?php
$query = "SELECT * FROM Restaurants WHERE name = '$restName'";
// Get results from query
  $result = mysqli_query($conn, $query);
  if (!$result) {
    die("Query to show fields from table failed");
  }
  $row = mysqli_fetch_row($result);
  echo "<h2 class='rest-page'>$restName</h2>
        <img src=$row[6] class='rest-page'>
        <p class='rest-page'>Address: $row[1] $row[3], $row[4] $row[2]</p>
        <p class='rest-page'>Type: $row[5]</p>
        <p class='rest-page'>Overall Rating: $row[7]</p>
          <a href='addReview.php?restName=$row[0]&zip=$row[2]&street=$row[1]' class='add-review-button-rest'>Add Review</a>
          <a href='browseRestaurants.php' class='add-review-button-rest'>Back to Browse</a>";
  echo "<h3 class='rest-page'>Reviews: </h3>";

  $reviewquery = "SELECT * FROM Review WHERE restaurantName = '$restName'";
  $reviewresult = mysqli_query($conn, $reviewquery);
  while($reviewrow = mysqli_fetch_row($reviewresult)){
    echo "<div id='restaurant-review-info'>
          <h3>$reviewrow[1]</h3>
            <p>Address: $reviewrow[2]</p>
            <p>Overall rating: $reviewrow[4]</p>
           <p>Review: $reviewrow[5]</lp>
           <p> Service Rating: $reviewrow[6], Food Rating: $reviewrow[7], Cost Rating: $reviewrow[8]</p>
           </div>";
  }
 ?>

</body>
