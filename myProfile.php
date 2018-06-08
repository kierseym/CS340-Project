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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
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
    echo "<h1>You are not logged in.</h1>
          <a href='home.php' class='add-review-button-rest'>Go home to log in</a>";
  }
  else{
    $userquery = "SELECT * FROM WebUsers WHERE username = '$user'";
    $userresult = mysqli_query($conn, $userquery);
    if (!$userresult) {
          echo "ERROR: Could not execute $userquery. " . mysqli_error($conn);
    }
    $userrow = mysqli_fetch_row($userresult);

    echo "<h1> Welcome $user </h1>
           <div id='user-info'>
           <h2> User Information: </h2>
           <p> Username: $userrow[0]</p>
           <p> Name: $userrow[2]</p>
           <p> Phone Number: $userrow[3]</p>";

  $workquery = "SELECT * FROM WorksAt WHERE username = '$user'";
  $worksatresult = mysqli_query($conn, $workquery);
  if (mysqli_num_rows($worksatresult)> 0) {
    $workrow = mysqli_fetch_row($worksatresult);
      echo "<p>Works at: $workrow[1]</p>
      <br /><a href='updateProfile.php' class='button-style'>Update Info</a>";
      echo "</div>";
  }
  else {
    echo "</div>";
  }



      $query = "SELECT * FROM Restaurants WHERE name IN (SELECT restaurantName FROM Favorite WHERE username = '$user')";
    // Get results from query
      $result = mysqli_query($conn, $query);
      if (!$result) {
            echo "ERROR: Could not execute $query. " . mysqli_error($conn);
      }
    // get number of columns in table
    //	$fields_num = mysqli_num_fields($result);
    echo "<div class='main-container'>
          <h2 class='profile-titles'>Favorited Restaurants:</h2>";
      //echo "<table id='t01' border='1'><tr>";

      while($row = mysqli_fetch_row($result)) {
    echo "
    <div class='restaurant' id='profile-restaurant'>
        <div class='restaurant-contents'>
          <div class='clearfix'>
			<div class='restaurant-image-container'>
            <img src=$row[6]>
			</div>
          <div class='restaurant-info-container-profile'>
            <a href='restaurant.php?restName=$row[0]' class='restaurant-title'>$row[0]</a>";
    if(!$row[7]){
      echo"</br><span class='restaurant-rating'>Not Yet Rated</span>";
    }
    else{
      echo"</br><span class='restaurant-rating'>Rating: $row[7]</span>";
    }
      echo "            <a href='deleteFavorite.php?restName=$row[0]&zip=$row[2]&street=$row[1]' class='add-review-button' id='browseRest'>Delete Favorite</a>
      </div>
      </div>
      </div>
      </div>";
    }

    $reviewquery = "SELECT * FROM Review WHERE username = '$user'";
    $reviewresult = mysqli_query($conn, $reviewquery);
    if (!$reviewresult) {
          echo "ERROR: Could not execute $reviewquery. " . mysqli_error($conn);
    }
    echo "<h2 class='profile-titles'>Your Reviews: </h2>";
    while($reviewrow = mysqli_fetch_row($reviewresult)) {
    echo "<div id='restaurant-review-info'>
          <h3>$reviewrow[1]</h3>
            <p>Address: $reviewrow[2]</p>
            <p>Overall rating: $reviewrow[4]</p>
           <p>Review: $reviewrow[5]</lp>
           <p> Service Rating: $reviewrow[6], Food Rating: $reviewrow[7], Cost Rating: $reviewrow[8]</p>
           </div>";
  }
  echo "</div>";
}

mysqli_free_result($result);
mysqli_close($conn);
?>
</body>
</html>
