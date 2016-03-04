<?php
  include("../includes.php");
  include("$root/admin/content.php");
  $title="Change Password";
  include("$root/header.php");

  if(isset($_POST['oldpass']) and isset($_POST['newpass'])) {

    // connect to DB
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // might need to do error handling for db connection here?

    // verify that the new user does not exist already
    // prepare select statement
    if (!($stmt = $mysqli->prepare("SELECT username,password FROM login where username = ? and password = ?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind username and emailAddr params
    if (!$stmt->bind_param("ss", $_SESSION['username'], sha1($_POST['oldpass']))) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // store the results of the query in order to count the num of results
    $result = $stmt->store_result();
    if ($stmt->num_rows() !== 1) {
      echo "Error occurred";
      die("error occurred");
    }
    $stmt->close();

    // if username or email is not in the database, add the user to the DB
    // prepare insert statement
    //if (!($stmt = $mysqli->prepare("INSERT INTO login (name,username,password,emailAddr,role) values (?, ?, ?, ?, ?)"))) {
    if (!($stmt = $mysqli->prepare("UPDATE login SET password = ? where username like ?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // bind username and emailAddr params
    if (!$stmt->bind_param("ss", sha1($_POST['newpass']), $_SESSION['username'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();

    $mysqli->close();

  }
?>

  <div id="bigContent">
    <?php
      echo "Password successfully updated.";
  	?>
  </div>
  <?php include("$root/footer.php"); ?>
