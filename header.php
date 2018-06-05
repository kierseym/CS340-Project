<?php session_start(); ?>

	<nav>
		<ul>

			<?php
				if(isset($_SESSION['user'])){
					$username = $_SESSION['user'];
					echo "<li class='title'>Welcome to Restaurant Reviews, $username</li>";
				} else {
					echo "<li class='title'>Welcome to Restaurant Reviews</li>";
				}
			 ?>

		<?php
		foreach ($content as $page => $location){
			echo "<li><a href='$location?user=".$username."' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
		}
		?>


	</nav>
