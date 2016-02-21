<div id="headerContainer">
	
		<div id="headerLeft">
			<div id="logo"><img src="<?php echo $domain?>images/boa_logo.gif" /></div>
		</div>
		<div id="headerRight">
			<div id="helpNav">
				<ul id="topNav">
					<li><a href="#">Sign-In</a></li>
					<li><a href="#">Locations</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Help</a></li>
					<li><a href="#">En espanol</a></li>						
				</ul>
			</div>
			<div id="search"><input type="text" id="searchBar"></div>
		</div>
	<div id="spacer"></div>
	<div id="topNavigation">
		<ul id="menu">
			<li><a href="<?php echo $domain?>index.php">Home</a></li>
			<li><a href="/html/default.asp">Small Business</a></li>
			<li><a href="/html/default.asp">Wealth Management</a></li>
			<li><a href="/html/default.asp">Business & Institutions</a></li>
		</ul> 
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
</div>