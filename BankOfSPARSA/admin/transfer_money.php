<?php
  include_once('content.php');
  include_once('../includes.php');

	// if not logged in as admin or no valid session exists, don't load the page
	if (isset($_SESSION['role']) and $_SESSION['role'] != 'admin' or !isset($_SESSION['role'])) {
    $title = "Unauthorized";
    include("$root/header.php");
		echo '<div id="bigContent">';
		echo "Unauthorized Request.";
		echo '</div>';
		include("$root/footer.php");
		die();
	}

  $amount = $_POST['amount'];
  //$destAccount = $_POST['destAccount'];
  if ($_POST['whiteteam'] === "true") {
    $destAccount = WHITE_TEAM_ACCT_NUM;
  }
  elseif (isset($_POST['destAccount'])) {
    $destAccount = $_POST['destAccount'];
  }
  else {
    $destAccount = "abc"; // arbitrary value if something goes wrong
  }

  $sessionID = get_session();

  // required parameters for /transferMoney
  // "accountNum","session","destAccount","amount"]
  $args  = array(
    'accountNum' => API_ACCOUNT_NUM,
    'session' => $sessionID,
    'destAccount' => $destAccount,
    'amount' => $amount
  );

  $result = build_api_request('/transferMoney',$args);
  $json_result = json_decode($result);

?>
<?php $title="Home"; ?>
<?php include("$root/header.php"); ?>
	<div id="bigContent">
		<table id="contentTable">
			<tr>
			<td id="contentText">
        <?php
          // catch error here
          if (!isset($json_result[0]->Status)) {
            //echo '$json_result[\'Status\'] = ' . $json_result['Status'] . " lollollol\n";
            echo $result . ' Click <a href="panel.php">here</a> to return to the admin panel.';
            echo '</div>';
            include("$root/footer.php");
            exit();
          }
          else {
            echo 'Your transfer has been completed. Click <a href="panel.php">here</a> to return to the admin panel.';
            //echo $json_result[0]->Status;
          }
        ?>
	</div>

<?php include("$root/footer.php"); ?>
</body>
</html>
