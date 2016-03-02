<?php
  session_start();      //starting the session for user profile page
?>
<?php include_once("../includes.php"); ?>
<?php $title="Login"; ?>
<?php include("$root/header.php"); ?>

	<div id="bigContent">
	<?php
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if(!empty($_POST['username']) and !empty($_POST['password'])) {
  		// prepare select statement
  		if (!($stmt = $mysqli->prepare("SELECT userID,name,username,password,role,emailAddr FROM login WHERE username = ? AND password = ?"))) {
  		  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  		}

  		// username and password are both strings (first param in bind_param)
  		if (!$stmt->bind_param("ss", $_POST['username'], sha1($_POST['password']))) {
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
  		  echo 'Incorrect username/password. Click <a href="../index.php">here</a> to return to the login page.';
  		  // Include our footer before we quit
  		  echo '</div>';
  		  include("$root/footer.php");
  		  exit();
  		}

  		//echo "variables: $userID $name $username $emailAddr $role";

  		if($role === 'admin') {
  		  // if the role is an admin, redirect to the admin page
  		  redirect($domain."admin/panel.php");
  		}
  		elseif($role === 'user') {
  		  // if the role is a user, redirect to user panel
  		  redirect($domain."user/panel.php");
  		}
		}
	?>
	</div>
  <?php include("$root/footer.php"); ?>
