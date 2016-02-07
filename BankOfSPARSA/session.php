<?php
include("includes/config.inc.php");
include("includes/functions.inc.php");

// connect to the DB
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

function SignIn() {
  session_start();      //starting the session for user profile page
  //print "USERNAME IS " . $_POST['username'];
  if(!empty($_POST['username'])) {
    //echo "query = mysql_query(\"SELECT * FROM login where username = '$_POST[username]' AND password = '$_POST[password]'\") or die(mysql_error());";
    $query = mysql_query("SELECT * FROM login where username = '$_POST[username]' AND password = '$_POST[password]'") or die(mysql_error());
  	$row = mysql_fetch_array($query) or die(mysql_error());
    echo "row is: ";
    print_r($row);
    if(!empty($row['username']) AND !empty($row['password'])) {
  		$_SESSION['username'] = $row['username'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['email'] = $row['emailAddr'];
      $_SESSION['userID'] = $row['userID'];
  		//echo $row['role'] . "\r\n";
      if($row['role'] == 'admin') {
        $_SESSION['role'] = 'admin';
        echo "SUCCESSFULLY LOGGED IN TO ADMIN PROFILE PAGE...\n";
        //print_r($_SESSION);
        //redirect('./admin/panel.php');
      }
      elseif($row['role'] == 'user') {
        $_SESSION['role'] = 'user';
        echo "SUCCESSFULLY LOGGED IN TO USER PROFILE PAGE...\n";
        //redirect('./user/panel.php');
      }
  	}
  	else {
      print_r($_SESSION);
  		echo "SORRY... YOU ENTERD WRONG ID AND PASSWORD... PLEASE RETRY...";
      //redirect('./index.php');
  	}
  }
}

if(isset($_POST['submit']))
{
  SignIn();
}

?>
