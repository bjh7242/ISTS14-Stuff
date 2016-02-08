<?php
  session_start();
  include_once('../includes/functions.inc.php');
  //include_once('../includes/config.inc.php')

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
    <input type="submit" value="submit" onclick="add_user.php"><br />
  </form>
</body>
</html>
