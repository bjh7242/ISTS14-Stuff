<?php
  session_start();

?>
<html>
<header>
  <title>Bank of SPARSA | User Panel</title>
</header>
<body>
  <h1>Welcome <?php echo $_SESSION['name']; ?>!</h1>
  <h2>Welcome to the User Panel</h2>
  <ul>
    <li><a href="/admin/user_mgmt.php">Check Balance</a></li>
  </ul>
