<html>
<head>
<title>Bank Of SPARSA</title>
<?php 
include_once("includes/functions.inc.php"); 
include_once("includes/config.inc.php");
?>
<?php
if(isMobile() == 0){
	echo '<link href="'.$domain.'/css/main.css" rel="stylesheet">';
}else{
	echo '<link href="'.$domain.'/css/main-mobile.css" rel="stylesheet">';
}
?>
</head>
<body>
<div id="bodyWrapper">
