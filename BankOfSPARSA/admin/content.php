<?php
  //session_start();
  include_once('../includes/functions.inc.php');

  function get_content($page) {
      if (!isset($page)) {
        $page = "";
      }

      switch ($page) {
        case 'add_user':
          add_user();
          break;
        case 'get_fed_balance':
          get_fed_balance();
          break;
        case 'change_fed_password':
          change_fed_password();
          break;
        default:
          echo "Please Select Choice.";
      }
  }

  function print_admin_panel($page) {
      echo "<h1>Admin Panel</h1>
      Welcome " . htmlspecialchars($_SESSION['username']) ."<br>";
      echo "<h2>Welcome to the Admin Panel</h2>
      Add the twitter feed here to see user feedback.<br />
      <ul>
        <li><a href=\"/admin/panel.php?page=add_user\">Add User</a></li>
        <li><a href=\"/admin/panel.php?page=get_fed_balance\">Get Fed Balance</a></li>
        Transfers to external accounts must not exceed the bank's balance in the fed.
        <li><a href=\"/admin/panel.php?page=change_fed_password\">Change Fed Password</a></li>
        <li><a href=\"/admin/panel.php?page=change_fed_pin\">Change Fed PIN</a></li>
        <li><a href=\"/admin/panel.php?page=transfer_to_bank\">Transfer Money to Other Bank</a></li>
        <li><a href=\"/admin/panel.php?page=transfer_internal_funds\">Transfer Internal User Funds</a></li>
      </ul>
      <div id=\"admin_content\">";
        get_content($page);
      echo "</div>\n";
  }

  function print_admin_panel_header() {
    echo "<head>
<title>Bank of SPARSA | Admin Panel</title>
</head>\n";
  }

  function add_user() {
    print_admin_panel_header();
    echo "<html>
    <head>
      <title>Bank of SPARSA | Add User</title>
    </head>
    <body>
      <form action=\"add_user.php\" method=\"post\">
        Name: <input type=\"text\" name=\"name\" /><br />
        Username: <input type=\"text\" name=\"username\" /><br />
        Email Address: <input type=\"text\" name=\"emailAddr\" /><br />
        Password: <input type=\"password\" name=\"password\" /><br />
        Role: <br />
        admin <input type=\"radio\" name=\"role\" value=\"admin\">
        user <input type=\"radio\" name=\"role\" value=\"user\" checked><br />
        <input type=\"submit\" value=\"submit\"><br />
      </form>
    </body>
    </html>";
  }

  function get_fed_balance() {
    echo "GET FED BALANCE";
  }

  function change_fed_password() {
    echo "CHANGE FED PASSWORD";
  }

?>
