<?php
  session_start();      //starting the session for user profile page

  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  include("$root/includes/config.inc.php");
  include("$root/includes/functions.inc.php");

  // connect to the DB
  //$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
  //$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  //print "USERNAME IS " . $_POST['username'];
  if(!empty($_POST['username']) and !empty($_POST['password'])) {
    //echo "query = mysql_query(\"SELECT * FROM login where username = '$_POST[username]' AND password = '$_POST[password]'\") or die(mysql_error());";
    //$query = mysql_query("SELECT * FROM login where username = '$_POST[username]' AND password = '$_POST[password]'") or die(mysql_error());
  	//$row = mysql_fetch_array($query);

    // prepare select statement
    if (!($stmt = $mysqli->prepare("SELECT userID,name,username,password,role,emailAddr FROM login WHERE username = ? AND password = ?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // username and password are both strings (first param in bind_param)
    if (!$stmt->bind_param("ss", $_POST['username'], $_POST['password'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }


    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // bind the results of the query to each field
    $stmt->bind_result($userID,$name,$username,$password,$role,$emailAddr);

    // store the results of the query in order to count the num of results
    $result = $stmt->store_result();
    if ($stmt->num_rows() === 1) {
      while ($stmt->fetch()) {
        //store the values for the last matched user
        $_SESSION['userID'] = $userID;
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['emailAddr'] = $emailAddr;
        $_SESSION['role'] = $role;
      }
    }
    else {
      echo "incorrect username/password :(";
      exit();
    }

    echo "variables: $userID $name $username $emailAddr $role";

    if($role === 'admin') {
      // if the role is an admin, redirect to the admin page
      redirect("../admin/panel.php");
    }
    elseif($role === 'user') {
      // if the role is a user, redirect to user panel
      redirect("../user/panel.php");
    }
  }

?>
