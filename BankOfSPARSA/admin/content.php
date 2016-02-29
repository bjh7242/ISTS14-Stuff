<?php
  //session_start();
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
        case 'transfer_to_bank':
          transfer_to_bank();
          break;
        case 'transfer_internal_funds':
          transfer_internal_funds();
          break;
        case 'view_account_funds':
          view_account_funds();
          break;
        case 'view_transactions':
          view_transactions();
          break;
        default:
          echo "Please Select Choice.";
      }
  }

  function print_admin_panel($page) {
	  global $domain;
      if (!isset($_SESSION['username'])) {
        $username = "";
      }
      else {
        $username = $_SESSION['username'];
      }
      echo '<script src="http://' . getLocalPath() . '/admin.js"></script>';
      echo "<h1>Admin Panel</h1>
      Welcome " . htmlspecialchars($username) ."<br>";
      echo "<h2>Welcome to the Admin Panel</h2>
      Add the twitter feed here to see user feedback.<br />
      <ul>
        <li><a href=\"".$domain."/admin/panel.php?page=add_user\">Add User</a></li>
        <li><a href=\"".$domain."/admin/panel.php?page=get_fed_balance\">Get Fed Balance</a></li>
        Transfers to external accounts must not exceed the bank's balance in the fed.
        <li><a href=\"".$domain."/admin/panel.php?page=change_fed_password\">Change Fed Password</a></li>
        <li><a href=\"".$domain."/admin/panel.php?page=change_fed_pin\">Change Fed PIN</a></li>
        <li><a href=\"".$domain."/admin/panel.php?page=transfer_to_bank\">Transfer Money to Other Bank</a></li>
        Transfers to other banks must not exceed $5000 within a 30 minute period.
        <li><a href=\"".$domain."/admin/panel.php?page=transfer_internal_funds\">Transfer Internal User Funds</a></li>
        <li><a href=\"".$domain."/admin/panel.php?page=view_account_funds\">View Internal User Funds</a></li>
        <li><a href=\"".$domain."/admin/panel.php?page=view_transactions\">View Transaction List</a></li>
      </ul>
      <div id=\"admin_content\">";
        get_content($page);
      echo "</div>\n";
  }



  function add_user() {
    echo "<form action=\"add_user.php\" method=\"post\">
        Name: <input type=\"text\" name=\"name\" /><br />
        Username: <input type=\"text\" name=\"username\" /><br />
        Email Address: <input type=\"text\" name=\"emailAddr\" /><br />
        Password: <input type=\"password\" name=\"password\" /><br />
        Role: <br />
        admin <input type=\"radio\" name=\"role\" value=\"admin\">
        user <input type=\"radio\" name=\"role\" value=\"user\" checked><br />
        <input type=\"submit\" value=\"submit\"><br />
      </form>";
  }

  // API request paramaters, $URI, array of ARGs
  function build_api_request($uri, $args_array) {
    $fields_string = "";
    $url = BANK_API_ADDRESS . ":" . BANK_API_PORT . $uri;

    foreach($args_array as $key=>$value) { $fields_string .= urlencode($key) . '=' . urlencode($value) . '&'; }
    rtrim($fields_string, "&");

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //execute post
    $result = curl_exec($ch);

    return $result;
  }

  // die if invalid session ID, else return session ID
  function get_session() {
    $fields_string = "";
    // required parameters for /getSession
    $args = array(
      'accountNum' => API_ACCOUNT_NUM,
      'password' => API_PASSWORD
    );
    $result = build_api_request("/getSession",$args);
    $json_result = json_decode($result);
    // print error code and die if not a valid session ID
    if (!isset($json_result->SessionID)) {
      echo $json_result;
      die();
    }
    else {
      return $json_result->SessionID;
    }
    
  }

  function get_fed_balance() {
    $sessionID = get_session();

    // required parameters for /getBalance
    $args  = array(
      'accountNum' => API_ACCOUNT_NUM,
      'session' => $sessionID
    );
    $result = build_api_request('/getBalance',$args);
    $json_result = json_decode($result);
    // catch error here
    if (!isset($json_result->Balance)) {
      echo $result;
      die();
    }
    echo "Balance is: $" . number_format($json_result->Balance,2);
  }

  function change_fed_password() {
    echo "<form action=\"change_fed_password.php\" method=\"post\">
        Current Password: <input type=\"password\" name=\"current_password\" /><br />
        New Password: <input type=\"password\" name=\"new_password\" /><br />
        New Password Verification: <input type=\"password\" name=\"new_password2\" /><br />
        <input type=\"submit\" value=\"submit\"><br />
      </form>";
  }

  function transfer_to_bank() {
    echo "TRANSFER TO BANK";
  }

  function transfer_internal_funds() {
    echo "<form name=\"transfer\" action=\"admin_transfer.php\" method=\"post\">
      Source Account Number: <input type=\"text\" name=\"src_acct\" value=\"\"><br>
      Destination Account Number: <input type=\"text\" name=\"dst_acct\" value=\"\"><br>
      Amount: <input type=\"text\" name=\"amount\" value=\"\"><br>
      <input type=\"submit\" name=\"submit\" value=\"Submit\">
    </form>";

    echo "TRANSFER INTERNAL FUNDS";
  }

  function view_account_funds() {
    // select login.username,login.emailAddr,accounts.accountNum,accounts.balance from login join accounts using(userID)
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if (!($stmt = $mysqli->prepare("SELECT login.username,login.emailAddr,accounts.accountNum,accounts.balance FROM login JOIN accounts USING(userID)"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // bind the results of the query to each field
    $stmt->bind_result($username,$emailAddr,$accountNum,$balance);

    echo "<table border=\"1\">";
    echo "<tr>\n<td>Username</td>\n<td>Email Address</td>\n<td>Account Number</td>\n<td>Balance</td>\n</tr>";
    // print the results
    while ($stmt->fetch()) {
      echo "<tr><td>" . $username . "</td>\n<td>" . $emailAddr . "</td>\n<td>" . $accountNum . "</td>\n<td>" . $balance . "</td></tr>\n";
    }

    echo "<br />";

    $stmt->close();
    $mysqli->close();
  }

  function view_transactions() {
    // select login.username,login.emailAddr,accounts.accountNum,accounts.balance from login join accounts using(userID)
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if (!($stmt = $mysqli->prepare("SELECT transactionID,src_routing_num,src_acct,dst_routing_num,dst_acct,amount,timestamp FROM transactions"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // bind the results of the query to each field
    $stmt->bind_result($transactionID,$src_routing_num,$src_acct,$dst_routing_num,$dst_acct,$amount,$timestamp);

    echo "<table border=\"1\">";
    echo "<tr>\n<td>Transaction ID</td>\n<td>Source Routing Number</td>\n<td>Source Account Number</td>\n<td>Destination Routing Number</td>\n<td>Destination Account Number</td>\n<td>Amount</td>\n<td>Timestamp</td>\n</tr>";
    // print the results
    while ($stmt->fetch()) {
      echo "<tr><td>" . $transactionID . "</td>\n<td>" . $src_routing_num . "</td>\n<td>" . $src_acct . "</td>\n<td>" . $dst_routing_num . "</td>\n<td>" . $dst_acct . "</td>\n<td>" . $amount . "</td>\n<td>" . $timestamp . "</td></tr>\n";
    }

    echo "<br />";

    $stmt->close();
    $mysqli->close();
  }

?>
