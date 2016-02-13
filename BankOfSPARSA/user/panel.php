<?php
  session_start();
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/functions.inc.php");
  include("$root/user/content.php");

?>
<html>
<?php
  print_user_panel_header();
?>
<body>
  <?php //print_user_panel();
  //print_admin_panel_header();
  echo "<body>";
  if (!isset($_GET['page'])) {
    $page = "";
  }
  else {
    $page = $_GET['page'];
  }
  print_user_panel($page);
  footer();
  echo "</body>";
   ?>
</body>
</html>
