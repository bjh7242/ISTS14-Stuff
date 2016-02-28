
	<div id="headerContainer">
		<div id="headerLeft">
			<div id="logo"><a href="#"><img width=70%; height=10%; class="pure-img" src="<?php echo $domain?>images/logo.jpg" /></a></div>
		</div>
		<div id="headerRight">
			<div id="helpNav">
				<ul id="topNav">
					<li><a class="topmenu" href="index.php">Sign-In</a></li>
					<li><a class="topmenu" href="#">Locations</a></li>
					<li><a class="topmenu" href="#">Contact Us</a></li>
					<li><a class="topmenu" href="#">Help</a></li>
				</ul>
			</div>

			<div id="search">
<form class="pure-form"><input type="text" placeholder="Search" id="searchBar"> <input type="submit" class="pure-button"></form></div>
		</div>

		<div id="spacer"></div>
		<div id="topNavigation" class="pure-menu pure-menu-horizontal">
			<ul id="menu" class="pure-menu-list">
				<li class="pure-menu-item"><a class="pure-menu-link" href="<?php echo $domain?>index.php">Home</a></li>
				<li class="pure-menu-item"><a class="pure-menu-link" href="/html/default.asp">Managment</a></li>
				<li class="pure-menu-item"><a class="pure-menu-link" href="/html/default.asp">Services</a></li>
				<li class="pure-menu-item"><a class="pure-menu-link" href="/html/default.asp">Business & Institutions</a></li>
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

