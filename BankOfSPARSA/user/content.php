<?php
  function get_content($page) {
    if (!isset($page)) {
      $page = "";
    }

    switch ($page) {
      case 'transfer_money':
        transfer_money();
        break;
      case 'transaction_history':
        transaction_history();
        break;
      case 'schedule_transfer':
        schedule_transfer();
        break;
      case 'check_transfer_schedule':
        check_transfer_schedule();
        break;
      case 'change_pin':
        change_pin();
        break;
      default:
        echo "Please Select Choice.";
    }
  }

  function print_user_panel_header() {
    echo "<head>
<title>Bank of SPARSA | User Panel</title>
</head>\n";
  }

  function print_user_panel($page) {
    echo "<h1>Welcome " . $_SESSION['name'] . "! Your last login was " . get_last_login($_SESSION['username']) . "</h1>
    <h2>Welcome to the User Panel</h2>
    Account Number: " . htmlspecialchars(get_accountNum($_SESSION['username'])) . "<br>
    Balance: " . htmlspecialchars(get_balance(get_accountNum($_SESSION['username']))) . "
    <br>
    <ul>
      <li><a href=\"/user/panel.php?page=transfer_money\">Transfer Money</a></li>
      <li><a href=\"/user/panel.php?page=transaction_history\">Transaction History</a></li>
      <li><a href=\"/user/panel.php?page=schedule_transfer\">Schedule Transfer</a></li>
      <li><a href=\"/user/panel.php?page=check_transfer_schedule\">Check Transfer Schedule</a></li>
      <li><a href=\"/user/panel.php?page=change_pin\">Change PIN</a></li>
    </ul>";
    get_content($page);
  }

  function transfer_money() {
    echo "<h3>Transfer Money</h3>
    <form name=\"transfer\" action=\"transfer.php\" method=\"post\">
      Destination Routing Number: <input type=\"text\" name=\"dst_routing_num\" value=\"\"><br>
      Destination Account Number: <input type=\"text\" name=\"dst_acct\" value=\"\"><br>
      Amount: <input type=\"text\" name=\"amount\" value=\"\"><br>
      <input type=\"submit\" name=\"submit\" value=\"Submit\">
    </form>";
    echo "TRANSFER.";
  }

  function transaction_history() {
    echo "TRANSACTION HISTORY";
  }

  function schedule_transfer() {
    echo "SCHEDULE TRANSFER";
  }

  function check_transfer_schedule() {
    echo "CHECK TRANSFER SCHEDULE";
  }

  function change_pin() {
    echo "CHANGE PIN";
  }
?>
