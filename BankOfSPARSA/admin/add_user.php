<?php
  session_start();
  //include('../includes/functions.inc.php');
  include_once('../includes/config.inc.php');

  if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['emailAddr']) && isset($_POST['role'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['emailAddr'];
    $role = $_POST['role'];

    // connect to DB
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // might need to do error handling for db connection here?
    $mysqli->query("INSERT INTO login (name,username,password,emailAddr,role) values ('$name','$username','$password','$email','$role')");

    // get user ID of new user
    $result = $mysqli->query("SELECT * FROM login WHERE username = '$username'");
    $row = $result->fetch_assoc();
    $newUserID = $row['userID'];

    // create random 6 digit PIN for new user
    $newPIN = rand(100000,999999);

    do {
      // create account for new user
      $newAcctNum = rand(1000000000,9999999999);

      // check to make sure the account number is not in use already
      $acctCheck = $mysqli->query("SELECT * FROM accounts where accountNum = '$newAcctNum'");
      $acctExists = $acctCheck->fetch_assoc();

      // break if the account did not exist, else loop again
      if (!isset($acctExists)) {
        break;
      }
    //} while (gettype($acctExists) != NULL);
  } while (true);
    echo "New Acct Number: " . $newAcctNum . "<br />";
    echo "New PIN: " . $newPIN;
    $mysqli->query("INSERT INTO accounts (userID,accountNum,accountPIN) values ('$newUserID','$newAcctNum','$newPIN')");
  }
  else {
    echo "Vars not set :(";
  }
/*
  $select = mysql_query("SELECT * FROM login WHERE username = '$username'");
  $row = mysql_fetch_array($select) or die(mysql_error());
  $userID = $row['userID'];
  //echo $userID;

  $newAcctNum = rand(1000000000,9999999999);
  $newPIN = rand(000000,999999);

  do {
    $checkAcctNum = mysql_query("SELECT * FROM accounts WHERE accountNum = '$newAcctNum'");
    $row = mysql_fetch_array($select) or die(mysql_error());
    print_r($row);
    if ($row) {
      //echo "lolololol the row is true";
      $acct = mysql_query("INSERT INTO accounts (userID,accountNum,accountPIN) values (
      '$userID', '$newAcctNum', '$newPIN'");
    }
  } while (empty($row['accountNum']));
  //else {
    //$acct = mysql_query("INSERT INTO accounts (userID,accountNum,accountPIN) values (
    //'$userID', '$newAcctNum', '$newPIN'");
  //}

*/
?>
