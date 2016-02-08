<?php
  session_start();
  //include('../includes/functions.inc.php');
  include_once('../includes/config.inc.php');

  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['emailAddr'];
  $role = $_POST['role'];
  $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());

  $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
  $query = mysql_query("INSERT INTO login (name,username,password,emailAddr,role) values ('$name','$username','$password','$email','$role')") or die(mysql_error());


  $select = mysql_query("SELECT * FROM login WHERE username = '$username'");
  $row = mysql_fetch_array($select) or die(mysql_error());
  $userID = $row['userID'];
  //echo $userID;

  $newAcctNum = rand(1000000000,9999999999);
  $newPIN = rand(000000,999999);

  do {
    $checkAcctNum = mysql_query("SELECT * FROM accounts WHERE accountNum = '$newAcctNum'");
    $row = mysql_fetch_array($select) or die(mysql_error());
    if ($row) {
      $acct = mysql_query("INSERT INTO accounts (userID,accountNum,accountPIN) values (
      '$userID', '$newAcctNum', '$newPIN'");
    }
  } while (empty($row['accountNum']));
  //else {
    //$acct = mysql_query("INSERT INTO accounts (userID,accountNum,accountPIN) values (
    //'$userID', '$newAcctNum', '$newPIN'");
  //}


?>
