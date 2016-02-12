<?php
include_once("config.inc.php");
ini_set('display_errors', 'On');

function redirect($page) {
  header('Location: ' . $page);
  exit();
}

function get_accountNum($username) {
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

  // verify that the new user does not exist already
  // prepare select statement
  //select userID,accountNum,login.username from accounts join login using(userID) where username = ?
  if (!($stmt = $mysqli->prepare("SELECT userID,accountNum,login.username FROM accounts JOIN login using(userID) WHERE username = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  // bind username and emailAddr params
  if (!$stmt->bind_param("s", $username)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  // bind the results of the query to each field
  $stmt->bind_result($userID,$acct,$user_name);

  // make sure only 1 account exists
  $result = $stmt->store_result();
  if ($stmt->num_rows() === 1) {
    while ($stmt->fetch()) {
      $accountNum = $acct;
    }
  }

  $stmt->close();
  $mysqli->close();

  return $accountNum;
}

function get_balance($accountNum) {
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

  // verify that the new user does not exist already
  // prepare select statement
  if (!($stmt = $mysqli->prepare("SELECT balance FROM accounts where accountNum = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  // bind username and emailAddr params
  if (!$stmt->bind_param("s", $accountNum)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  // bind the results of the query
  $stmt->bind_result($balance);

  // make sure only 1 account exists, set the balance to $bal and return that
  $result = $stmt->store_result();
  if ($stmt->num_rows() === 1) {
    while ($stmt->fetch()) {
      $bal = $balance;
    }
  }

  $stmt->close();
  $mysqli->close();

  return round($bal,2);
}

?>
