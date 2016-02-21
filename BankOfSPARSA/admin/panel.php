<?php
	include_once("../includes.php");
	session_start();
	include("$root/admin/content.php");
	$title="Login";
	include("$root/header.php");
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
