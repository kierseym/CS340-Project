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
  $msg = "Profile";
  include 'connectvars.php';
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
  if(!$user){
    echo "<h1>You are not logged in.</h1>";
  }
  else{
    $userquery = "SELECT * FROM WebUsers WHERE username = '$user'";
    $userresult = mysqli_query($conn, $userquery);
    if (!$userresult) {
          echo "ERROR: Could not execute $userquery. " . mysqli_error($conn);
    }
    $userrow = mysqli_fetch_row($userresult);

    echo "<h1> Welcome $user </h1>
           <h2> User Information: </h2>
           <ul>
           <li> Username: $userrow[0]</li>
           <li> Name: $userrow[2]</li>
           <li> Phone Number: $userrow[3]</li>
           </ul>";


      $query = "SELECT * FROM Restaurants WHERE name IN (SELECT restaurantName FROM Favorite WHERE username = '$user')";
    // Get results from query
      $result = mysqli_query($conn, $query);
      if (!$result) {
            echo "ERROR: Could not execute $query. " . mysqli_error($conn);
      }
    // get number of columns in table
    //	$fields_num = mysqli_num_fields($result);
      echo "<h2>Favorited Restaurants:</h2>";
      //echo "<table id='t01' border='1'><tr>";

      while($row = mysqli_fetch_row($result)) {
    echo"<div class='restaurant'>
        <div class='restaurant-contents'>
          <div class='restaurant-image-container'>
            <img src=$row[6]>
          </div>
          <div class='restaurant-info-container'>
            <a href='#' class='restaurant-title'>$row[0]</a>";
    if(!$row[7]){
      echo"<span class='restaurant-rating'>Not Yet Rated</span> <span class='restaurant-city'>$row[3]</span>";
    }
    else{
      echo"<span class='restaurant-rating'>Rating: $row[7]</span> <span class='restaurant-city'>$row[3]</span>";
    }
      echo "</div>
        </div>
      </div>";
    }

    $reviewquery = "SELECT * FROM Review WHERE username = '$user'";
    $reviewresult = mysqli_query($conn, $reviewquery);
    if (!$reviewresult) {
          echo "ERROR: Could not execute $reviewquery. " . mysqli_error($conn);
    }
    $reviewrow = mysqli_fetch_row($reviewresult);

    echo "<h2> User Reviews: </h2>
           <ul>
           <li> Restaurant: $reviewrow[1]</li>
           <li> Address: $reviewrow[2]</li>
           <li> Zip: $reviewrow[3]</li>
           <li> Overall Rating: $reviewrow[4]</li>
           <li> Review: $reviewrow[5]</li>
           <li> Service Rating: $reviewrow[6]</li>
           <li> Food Rating: $reviewrow[7]</li>
           <li> Cost Rating: $reviewrow[8]</li>
           </ul>";
  }

mysqli_free_result($result);
mysqli_close($conn);
?>
</body>
</html>
