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
  <h1>Welcome <?php echo $_SESSION['name']; ?>! Your last login was <?php echo get_last_login($_SESSION['username']); ?></h1>
  <h2>Welcome to the User Panel</h2>
  Account Number: <?php echo get_accountNum($_SESSION['username']); ?><br>
  Balance: $<?php echo get_balance(get_accountNum($_SESSION['username'])); ?>
  <br>

    <h3>Transfer Money</h3>
    <form name="transfer" action="transfer.php" method="post">
      Destination Routing Number: <input type="text" name="Destination Routing Number" value=""><br>
      Destination Account Number: <input type="text" name="Destination Account Number" value=""><br>
      <input type="submit" name="submit" value="Submit">
    </form>
  <ul>
    <li><a href="">Transaction History</a></li>
    <li><a href="">Schedule Transfer</a></li>
    <li><a href="">Check Transfer Schedule</a></li>
    <li><a href="">Change PIN</a></li>
  </ul>
  <?php footer(); ?>
</body>
</html>
