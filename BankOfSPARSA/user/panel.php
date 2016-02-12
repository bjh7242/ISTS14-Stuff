<?php
  session_start();
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/functions.inc.php");

?>
<html>
<header>
  <title>Bank of SPARSA | User Panel</title>
</header>
<body>
  <h1>Welcome <?php echo $_SESSION['name']; ?>! Your last login was TIME</h1>
  <h2>Welcome to the User Panel</h2>
  Account Number: <?php echo get_accountNum("whatever"); ?><br>
  Balance: <?php echo get_balance('4230532417'); ?>
  <br>
  <ul>
    <li><a href="/user/user_mgmt.php">Check Balance</a></li>
    <li><a href="">Transfer Money</a></li>
    <li><a href="">Transaction History</a></li>
    <li><a href="">Schedule Transfer</a></li>
    <li><a href="">Check Transfer Schedule</a></li>
    <li><a href="">Change PIN</a></li>
  </ul>
