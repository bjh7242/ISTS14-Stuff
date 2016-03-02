<?php include_once("includes.php"); ?>
<?php $title="Login"; ?>
<?php include("$root/header.php"); ?>

	<div id="bigContent">
		<table id="contentTable">
			<tr>
			<td id="contentText">
		<h1>Bank of SPARSA</h1>
		<h2>Login</h2>
		<form name="login" action="main/session.php" method="post">
		Username: <input type="text" name="username" value=""><br />
		Password: <input type="password" name="password" value="" autocomplete="off"><br />
		<input type="submit" name="submit" value="Submit">
		</form>
		Forgot your password? Reset it <a href="">here</a>.
		</div>
			</td>
			<td id="tweet">
			<iframe id="twit" src="twitinc.php"></iframe>
			</td>
			</tr>
		</table>
		
	</div>
  <?php include("$root/footer.php"); ?>
</body>
</html>
