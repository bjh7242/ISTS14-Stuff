<?php
  session_start();
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/functions.inc.php");
  include("$root/admin/content.php");
?>

<html>
  <?php
    print_admin_panel_header();
    echo "<body>";
    print_admin_panel($_GET['page']);
    footer();
    echo "</body>";
  ?>
</html>
