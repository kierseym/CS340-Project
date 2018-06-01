<?php
	session_start();
	if(isset($_SESSION["name"])){
		$user = $_SESSION["name"];
	}
	else{
		$user = " ";
	}
 ?>
	<header>
		Restaurant Reviews<em><span id="username"><?php echo $user?></span></em>
	</header>
	<nav>
		<ul>
		<?php
		foreach ($content as $page => $location){
			echo "<li><a href='$location?user=".$username."' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
		}
		?>
		<li>
			<?php
				session_start();
					session_destroy();

				?>
				<a href="home.php">Logout</a></li>
	</ul>
<!--
		<li><a href="/signUp.php">Sign up</a></li>
		<li><a href="/listUsers.php">List Users</a><li>
		</ul>-->

	</nav>
