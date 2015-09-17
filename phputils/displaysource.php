<?php
	$file = "../".$_GET["filename"];
	echo "<h1>Source Code for: ".$file."</h1>";
	highlight_file($file);
?>
