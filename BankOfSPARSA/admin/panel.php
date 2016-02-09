<?php
  session_start();
?>
<head>
  <title>Bank of SPARSA | Admin Panel</title>
</head>
<body>
  <h1>Admin Panel</h1>
  <?php
    echo "Welcome " . $_SESSION['username'];
    //echo "hello";
    //print_r($_SESSION);
  ?>
  <h2>Welcome to the Admin Panel</h2>
  <ul>
    <li><a href="/admin/user_mgmt.php">Add User</a></li>
  </ul>
</body>
</html>
