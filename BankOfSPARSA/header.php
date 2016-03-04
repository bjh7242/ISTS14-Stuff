<?php
  // adding for session management on every page
  if(session_status() == PHP_SESSION_NONE){
    session_start();      //starting the session for user profile page
  }

?>
	<div id="headerContainer">
		<div id="headerLeft">
			<div id="logo"><a href="#"><img width=70%; height=10%; class="pure-img" src="<?php echo $domain?>images/logo.jpg" /></a></div>
		</div>
		<div id="headerRight">
			<div id="helpNav">
				<ul id="topNav">
					<?php
                        $pagename = basename($_SERVER["SCRIPT_FILENAME"]);
						// determine whether user is logged in or not and print the appropriate session page (sign in or out)
					  if (isset($_SESSION['role']) && $pagename != "signout.php") {
							echo '<li><a class="topmenu" href="' . $domain . 'signout.php">Sign-Out</a></li>';
                        }
						else {
							echo '<li><a class="topmenu" href="' . $domain . 'signin.php">Sign-In</a></li>';
						}
					?>
					<li><a class="topmenu" href="<?php echo $domain?>locations.php">Locations</a></li>
					<li><a class="topmenu" href="<?php echo $domain?>contact.php">Contact Us</a></li>
					<li><a class="topmenu" href="<?php echo $domain?>help.php">Help</a></li>
				</ul>
			</div>

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
				<li class="pure-menu-item"><a class="pure-menu-link" href="<?php echo $domain?>services.php">Services</a></li>
				<li class="pure-menu-item"><a class="pure-menu-link" href="<?php echo $domain?>business.php">Business &amp; Institutions</a></li>
			</ul>
		</div>
	</div>
	<div id="title"><h1 id="titleText">
	<?php
        if(isMobile() && isset($_POST['username']) && isset($_POST['password'])){
           $username = "'" .$_POST['username'] . "'"; $password = "'" . sha1($_POST['password']) . "'";
        }

		if(isset($title)){
			echo htmlspecialchars($title,ENT_HTML5|ENT_IGNORE|ENT_QUOTES);
		}else{
			echo "";
		}
	?>
	</h1></div>
