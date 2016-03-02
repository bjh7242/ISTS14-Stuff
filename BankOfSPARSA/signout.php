<?php include_once("includes.php"); ?>
<?php $title="Signout"; ?>
<?php include("$root/header.php"); ?>
<?php
  // session_start() not needed because it is included in the header
  session_destroy();
?>
	<div id="bigContent">
		<table id="contentTable">
			<tr>
			<td id="contentText">
		<h1>Bank of SPARSA</h1>
		<h2>Signout</h2>
		<p>You have been signed out.</p>
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
