<?php
 if(!empty($_REQUEST['updateIndex']) && !empty($_REQUEST['updated'])){
	 $index = $_REQUEST['updateIndex'];
         $text = $_REQUEST['updated'];
	 $pathx = substr(getcwd(),0,strrpos(getcwd(),'/'));
	 $path = scandir($pathx);
	 $changed = $pathx.'/'.$path[$index];
	$myfile = fopen($changed, "w") or die("Unable to open file!");
	fwrite($myfile, $text);
	 fclose($myfile);
         echo "Updated " . $path[$index] . "<br>";
	echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
 }
 if(!empty($_REQUEST['file'])){
	 $index = $_REQUEST['file'];
	 $pathx = substr(getcwd(),0,strrpos(getcwd(),'/'));
	 $path = scandir($pathx);
	 $changed = $pathx.'/'.$path[$index];
	 $myfile = fopen($changed, "r") or die("Unable to open file!");
	 echo '<form action="getFile.php" method="GET">';
	 echo '<input type="hidden" name="updateIndex" value="'.$index.'">';
	 echo '<textarea name="updated" rows="50" cols="67">';
	 echo fread($myfile,filesize($changed));
	 echo '</textarea><br><input type="submit" value="Update"></form>';
	 fclose($myfile);
 }
?>
