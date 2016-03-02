<?php
  include_once('content.php');
  include_once('../includes.php');

  function change_password($newPassword) {
    $sessionID = get_session();
    echo "SESSION ID IS: " . htmlspecialchars($sessionID) . "\n";
    if (!isset($sessionID)) {
      echo "sessionID is not set?";
      echo htmlspecialchars($sessionID);
      die();
    }
    else {
      //$sessionID = $session->SessionID;
      // required parameters for /changePassword
      $args  = array(
        'accountNum' => API_ACCOUNT_NUM,
        'session' => $sessionID,
        'newPassword' => $newPassword
      );
      $result = build_api_request('/changePassword',$args);
      // error handling for changing the password
      if (!isset($result->Status)) {
        echo $result;
        die();
      }
      $json_result = json_decode($result);
      // if there is an error, $json_result->Status will return 'False'
      if (!isset($json_result->Status)) {
        echo "password change worked.";
        echo $json_result;
      }
      else {
        echo $json_result->Status;
      }
    }

  }

  // verify that the new password matches both entries
  function verify_matching_password() {
    if ($_POST['new_password'] !== $_POST['new_password2']) {
      echo "ERROR: passwords do not match.";
      die();
    }
  }

  verify_matching_password();
  change_password($_POST['new_password']);

?>
