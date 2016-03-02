<?php
  // adding for session management on every page
  session_start();
?>
	<div id="headerContainer">
		<div id="headerLeft">
			<div id="logo"><a href="#"><img width=70%; height=10%; class="pure-img" src="<?php echo $domain?>images/logo.jpg" /></a></div>
		</div>
		<div id="headerRight">
			<div id="helpNav">
				<ul id="topNav">
					<?php
						// determine whether user is logged in or not and print the appropriate session page (sign in or out)
					  if (isset($_SESSION['role'])) {
							echo '<li><a class="topmenu" href="' . $domain . 'signout.php">Sign-Out</a></li>';
						}
						else {
							echo '<li><a class="topmenu" href="' . $domain . 'signin.php">Sign-In</a></li>';
						}
					?>
					<li><a class="topmenu" href="<?php echo $domain?>locations.php">Locations</a></li>
					<li><a class="topmenu" href="<?php echo $domain?>contact.php">Contact Us</a></li>
					<li><a class="topmenu" href="#">Help</a></li>
				</ul>
			</div>

			<div id="search">
<form class="pure-form"><input type="text" placeholder="Search" id="searchBar"> <input type="submit" class="pure-button"></form></div>
		</div>

		<div id="spacer"></div>
		<div id="topNavigation" class="pure-menu pure-menu-horizontal">
			<ul id="menu" class="pure-menu-list">
				<?php
				  if (isset($_SESSION['role'])) {
						echo '<li class="pure-menu-item"><a class="pure-menu-link" href="' . $domain . $_SESSION['role'] . '/panel.php">Home</a></li>';
					}
					else {
						echo '<li class="pure-menu-item"><a class="pure-menu-link" href="' . $domain . 'index.php">Home</a></li>';
					}
				?>
				<li class="pure-menu-item"><a class="pure-menu-link" href="<?php echo $domain?>managment.php">Managment</a></li>
				<li class="pure-menu-item"><a class="pure-menu-link" href="/html/default.asp">Services</a></li>
				<li class="pure-menu-item"><a class="pure-menu-link" href="/html/default.asp">Business &amp; Institutions</a></li>
			</ul>
		</div>
	</div>
	<div id="title"><h1 id="titleText">
	<?php
		if(isset($title)){
			echo htmlspecialchars($title,ENT_HTML5|ENT_IGNORE|ENT_QUOTES);
		}else{
			echo "";
		}
	?>
	</h1></div>
