

	<header>
		Restaurant Reviews - <em><span id="username"><?php echo $user;?></span>!</em>
	</header>
	<nav>
		<ul>
		<?php
		foreach ($content as $page => $location){
			echo "<li><a href='$location?user=".$user."' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
		}
		?>
<!--
		<li><a href="/signUp.php">Sign up</a></li>
		<li><a href="/listUsers.php">List Users</a><li>
		</ul>-->

	</nav>
