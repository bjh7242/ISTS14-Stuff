<?php
	include_once("../includes.php");
	include("$root/admin/content.php");
	$title="Login";
	include("$root/header.php");
	// if not logged in as admin or no valid session exists, don't load the page
	if (isset($_SESSION['role']) and $_SESSION['role'] != 'admin' or !isset($_SESSION['role'])) {
		echo '<div id="bigContent">';
		echo "Unauthorized.";
		echo '</div>';
		include("$root/footer.php");
		die();
	}
?>
<div id="bigContent">
  <?php
    if (!isset($_GET['page'])) {
      $page = "";
    }
    else {
      $page = $_GET['page'];
    }
    print_admin_panel($page);
	?>
</div>
  <?php include("$root/footer.php"); ?>
