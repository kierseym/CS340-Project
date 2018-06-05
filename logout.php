<?php
 session_start();

  echo "Logout Successful ";
  session_destroy();   // Destroys Session 
  header("Location: login.php");
?>
