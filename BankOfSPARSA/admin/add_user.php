<?php
  session_start();
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  //include('$root/includes/functions.inc.php');
  include_once("$root/includes/config.inc.php");

  if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['emailAddr']) && isset($_POST['role'])) {
    // connect to DB
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // might need to do error handling for db connection here?

    // verify that the new user does not exist already
    // prepare select statement
    if (!($stmt = $mysqli->prepare("SELECT username FROM login where username = ? OR emailAddr = ?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind username and emailAddr params
    if (!$stmt->bind_param("ss", $_POST['username'], $_POST['emailAddr'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // store the results of the query in order to count the num of results
    $result = $stmt->store_result();
    if ($stmt->num_rows() !== 0) {
      echo "Username or Email Address Already exists.";
      die();
    }
    $stmt->close();

    // if username or email is not in the database, add the user to the DB
    // prepare insert statement
    if (!($stmt = $mysqli->prepare("INSERT INTO login (name,username,password,emailAddr,role) values (?, ?, ?, ?, ?)"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind username and emailAddr params
    if (!$stmt->bind_param("sssss", $_POST['name'], $_POST['username'], $_POST['password'], $_POST['emailAddr'], $_POST['role'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();

    // get the user ID of the new user
    // prepare select statement
    if (!($stmt = $mysqli->prepare("SELECT userID FROM login WHERE username = ?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind username and emailAddr params
    if (!$stmt->bind_param("s", $_POST['username'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // bind the results of the query to each field
    $stmt->bind_result($userID);
    $stmt->close();

    // create random 6 digit PIN for new user
    $newPIN = rand(100000,999999);

    // get the existing account numbers
    // prepare select statement
    if (!($stmt = $mysqli->prepare("SELECT accountNum FROM accounts where accountNum = ?"))) {
      echo "acct check Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    do {
      // create account for new user
      $newAcctNum = rand(1000000000,9999999999);

      // bind new account num param
      if (!$stmt->bind_param("i", $newAcctNum)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }

      if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }

      // bind the results of the query to each field
      $stmt->bind_result($acctExists);

      $result = $stmt->store_result();
      if ($stmt->num_rows() === 1) {
        while ($stmt->fetch()) {
          //store the values for the last matched user
          $existingAcct = $acctExists;
        }
      }
      // break if the account number was not found in the DB, else loop again
      if (!isset($existingAcct)) {
        break;
        $stmt->close();
      }
    } while (true);
    echo "New Acct Number: " . $newAcctNum . "<br />";
    echo "New PIN: " . $newPIN;

    // insert new account info into the DB
    // prepare insert statement
    if (!($stmt = $mysqli->prepare("INSERT INTO accounts (userID,accountNum,accountPIN) values (?, ?, ?)"))) {
      echo "INSERT Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind new account num param
    if (!$stmt->bind_param("iii", $userID, $newAcctNum, $newPIN)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

  }
  else {
    echo "Vars not set :(";
  }
  $mysqli->close();
?>
