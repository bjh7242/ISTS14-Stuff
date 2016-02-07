<?php
require_once("includes/config.inc.php");
require_once("includes/functions.inc.php");

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

function SignIn()
{
  session_start();      //starting the session for user profile page
  if(!empty($_POST['username']))
  {
  	$query = mysql_query("SELECT * FROM login where username = '$_POST[username]' AND password = '$_POST[password]'") or die(mysql_error());
  	$row = mysql_fetch_array($query) or die(mysql_error());
  	if(!empty($row['username']) AND !empty($row['password']))
  	{
  		$_SESSION['username'] = $row['password'];
  		echo "SUCCESSFULLY LOGIN TO USER PROFILE PAGE...\n";
      //echo $row['role'] . "\r\n";
      if($row['role'] == 'admin') {
        //$_SESSION['is_admin'] == "true";
        redirect('http://localhost/admin/panel.php');
        //print_r($_SESSION);
        //print_r($_POST);
      }
  	}
  	else
  	{
  		echo "SORRY... YOU ENTERD WRONG ID AND PASSWORD... PLEASE RETRY...";
  	}
  }
}

if(isset($_POST['submit']))
{
  SignIn();
}

?>
