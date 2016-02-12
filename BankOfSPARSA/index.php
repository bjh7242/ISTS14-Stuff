<?php
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/functions.inc.php");
?>
<html>
<head>
  <title>Bank of SPARSA</title>
</head>
<body>
  <h1>Bank of SPARSA</h1>
  <h2>Login</h2>
  <?php
  /*
    echo $_SERVER['SERVER_NAME'];
  */
  ?>
  <form name="login" action="/main/session.php" method="post">
    Username: <input type="text" name="username" value="Username"><br />
    Password: <input type="password" name="password" value="password" autocomplete="off"><br />
    <input type="submit" name="submit" value="Submit">
  </form>
  Forgot your password? Reset it <a href="">here</a>.
  <?php footer(); ?>
</body>
</html>
