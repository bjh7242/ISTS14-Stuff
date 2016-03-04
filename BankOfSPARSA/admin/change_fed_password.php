<?php
  include("../includes.php");
  include("$root/admin/content.php");
  $title="Change Fed Password";
  include("$root/header.php");

  function change_password($newPassword) {
    global $root;
    $sessionID = get_session();
    //echo "SESSION ID IS: " . htmlspecialchars($sessionID) . "\n";
    if (!isset($sessionID)) {
      echo "sessionID is not set?";
      //echo htmlspecialchars($sessionID);
      die();
    }
    else {
      //$sessionID = $session->SessionID;
      // required parameters for /changePassword
      $args  = array(
        'accountNum' => API_ACCOUNT_NUM,
        'session' => $sessionID,
        'newPassword' => $newPassword,
        'password' => $_POST['current_password']
      );
      $result = build_api_request('/changePassword',$args);
      // error handling for changing the password
      $json_result = json_decode($result);
      //echo "json_result-Status = " . $json_result->Status;
      if (!isset($json_result->Status)) {
        echo '<div id="bigContent">';
        echo "Invalid request.";
        echo '</div>';
        include("$root/footer.php");
        die();
      }
      else {
        echo '<div id="bigContent">';
        echo $json_result->Status . '<br />';
        echo "Please update your config.inc.php file to reflect your changed password in order to prevent errors when accessing the fed API.";
        echo '</div>';
        include("$root/footer.php");
        die();
      }
    }

  }

  // verify that the new password matches both entries
  function verify_matching_password() {
    if ($_POST['new_password'] !== $_POST['new_password2']) {
      global $root;
      echo '<div id="bigContent">';
      echo "Passwords do not match.";
      echo '</div>';
      include("$root/footer.php");
      die();
    }
  }

  verify_matching_password();
  change_password($_POST['new_password']);

?>
