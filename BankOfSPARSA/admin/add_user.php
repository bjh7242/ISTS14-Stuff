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

    // verify that the new user does not exist already
    $userCheck = $mysqli->query("SELECT * FROM login where username = '$username'");
    $userExists = $userCheck->fetch_assoc();
    if (isset($userExists)) {
      echo "Username or email address is already registered.";
      exit();
    }

    // verify that the email addr of the new user does not exist already
    $emailCheck = $mysqli->query("SELECT * FROM login where emailAddr = '$email'");
    $emailExists = $userCheck->fetch_assoc();
    if (isset($emailExists)) {
      echo "Username or email address is already registered.";
      exit();
    }

    // add the user to the DB
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
    } while (true);
    echo "New Acct Number: " . $newAcctNum . "<br />";
    echo "New PIN: " . $newPIN;
    $mysqli->query("INSERT INTO accounts (userID,accountNum,accountPIN) values ('$newUserID','$newAcctNum','$newPIN')");
  }
  else {
    echo "Vars not set :(";
  }

?>
