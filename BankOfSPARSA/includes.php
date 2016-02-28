<html>
<head>
<title>Bank Of SPARSA</title>
<?php 
include_once("includes/functions.inc.php"); 
include_once("includes/config.inc.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$( document ).ready(function() {
    	windowHeight = $("#bigContent").height();
	
	 $("#twit").css("height", windowHeight+45); 
});
</script>



</script>
<?php
if(isMobile() == 0){
	echo '<link href="'.$domain.'/css/main.css" rel="stylesheet">';
}else{
	echo '<link href="'.$domain.'/css/main-mobile.css" rel="stylesheet">';
}

?>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>
<div id="bodyWrapper">
