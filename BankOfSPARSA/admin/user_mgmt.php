<?php
  session_start();
/*
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include_once("$root/includes/functions.inc.php");
*/
?>

<html>
<head>
  <title>Bank of SPARSA | Add User</title>
</head>
<body>
  <form action="add_user.php" method="post">
    Name: <input type="text" name="name" /><br />
    Username: <input type="text" name="username" /><br />
    Email Address: <input type="text" name="emailAddr" /><br />
    Password: <input type="password" name="password" /><br />
    Role: <br />
    admin <input type="radio" name="role" value="admin">
    user <input type="radio" name="role" value="user" checked><br />
    <input type="submit" value="submit"><br />
  </form>
</body>
</html>
