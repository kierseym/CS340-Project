<?php session_start(); ?>
<?php
	if(isset($_SESSION['user']))
	{
	}

 ?>
	<nav>
		<ul>
			<li class='title'>Restaurant Reviews</li>
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
