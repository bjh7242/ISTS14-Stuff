<?php
  include_once('content.php');
  include_once('../includes.php');

  /*if (!is_null($_POST['new_pin'])) {
    $new_pin = $_POST['new_pin'];
  }*/
  // should probably do error handling here. that's a later problem.
  $new_pin = $_POST['new_pin'];
  $old_pin = $_POST['old_pin'];

  $sessionID = get_session();

  // required parameters for /getPin
  //required = ["accountNum","session","newPin"]
  $args  = array(
    'accountNum' => API_ACCOUNT_NUM,
    'session' => $sessionID,
    'newPin' => $new_pin,
    'pin' => $old_pin
  );

  $result = build_api_request('/changePin',$args);
  $json_result = json_decode($result);

?>
<?php $title="Change PIN"; ?>
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
            echo 'Your PIN has successfully been changed. Click <a href="panel.php">here</a> to return to the admin panel.';
            //echo $json_result[0]->Status;
          }
        ?>
	</div>

<?php include("$root/footer.php"); ?>
</body>
</html>
