<?php
  session_start();
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/config.inc.php");
  include("$root/includes/functions.inc.php");

  if (isset($_POST['dst_routing_num']) AND isset($_POST['dst_acct']) AND isset($_POST['amount'])) {
    $dst_routing_num = $_POST['dst_routing_num'];
    $dst_account_num = $_POST['dst_acct'];
    $amount = $_POST['amount'];
    $current_balance = get_balance(get_accountNum($_SESSION['username']));

    if (!filter_var($dst_routing_num,FILTER_VALIDATE_INT) AND !filter_var($dst_account_num, FILTER_VALIDATE_INT) AND !filter_var($amount, FILTER_VALIDATE_FLOAT)) {
      echo "Invalid Parameter. Please enter a valid routing number, account number, and amount.";
      die();
    }

    // error check to see if the amount is valid
    if ($amount < 0) {
      echo "Invalid amount. Must be a positive number.";
      die();
    }
    if ($amount > $current_balance) {
      echo "Invalid amount. Must be less than or equal to the current account balance.";
      die();
    }

    // connect to DB
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    // check the routing number for the remote bank here
    // if me, check to see if the dest account is a valid account
    if (!($stmt = $mysqli->prepare("SELECT accountNum FROM accounts where accountNum = ?"))) {
      echo "acct check Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind new account num param
    if (!$stmt->bind_param("i", $dst_account_num)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // bind the results of the query to each field
    // if $dst_routing_num === $my_routing_num
    $stmt->bind_result($dst_acct);

    // if the account number is invalid in the local database, die
    $result = $stmt->store_result();
    if ($stmt->num_rows() !== 1) {
      echo "Unable to validate account number.";
      die();
    }

    // subtract the amount from the current balance, and set the new account balance
    $new_src_bal = get_balance(get_accountNum($_SESSION['username'])) - $amount;
    update_balance(get_accountNum($_SESSION['username']), $new_src_bal);

    // add new amount to dest balance
    $new_dst_bal = get_balance($dst_account_num) + $amount;
    update_balance($dst_account_num, $new_dst_bal);

    // write transaction log to the DB
    log_transaction("12345", get_accountNum($_SESSION['username']), $dst_routing_num, 3988282199, $amount);

    echo "Done processing transaction.";
    // if different bank, ask fed if account num is valid
  }

?>
