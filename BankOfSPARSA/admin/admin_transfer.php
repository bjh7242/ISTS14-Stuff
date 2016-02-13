<?php
  session_start();
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/config.inc.php");
  include("$root/includes/functions.inc.php");

  if (isset($_POST['src_acct']) AND isset($_POST['dst_acct']) AND isset($_POST['amount'])) {
    $src_acct = $_POST['src_acct'];
    $dst_account_num = $_POST['dst_acct'];
    $amount = $_POST['amount'];
    $current_balance = get_balance($src_acct);

    if (!filter_var($src_acct,FILTER_VALIDATE_INT) AND !filter_var($dst_account_num, FILTER_VALIDATE_INT) AND !filter_var($amount, FILTER_VALIDATE_FLOAT)) {
      echo "Invalid Parameter. Please enter valid account numbers and amount.";
      die();
    }

    // get_balance returns NULL if the account number is invalid
    if (is_null($current_balance)) {
      echo "Invalid Source Account number.";
      die();
    }

    // is $dst_acct balance is null, account doesn't exist
    if (is_null(get_balance($dst_account_num))) {
      echo "Invalid Destination Account number.";
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

    // subtract the amount from the current balance, and set the new account balance
    $new_src_bal = get_balance($src_acct) - $amount;
    update_balance($src_acct, $new_src_bal);

    // add new amount to dest balance
    $new_dst_bal = get_balance($dst_account_num) + $amount;
    update_balance($dst_account_num, $new_dst_bal);

    // write transaction log to the DB
    log_transaction(LOCAL_ROUTING_NUMBER, $src_acct, LOCAL_ROUTING_NUMBER, $dst_account_num, $amount);

    echo "Done processing transaction.";
    // if different bank, ask fed if account num is valid
  }

?>
