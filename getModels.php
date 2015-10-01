<?php
	include("phputils/conn.php");
	if(isset($_GET["Make_Name"])) {
		$make = $_GET["Make_Name"];			
		$query="SELECT c.MODEL_NAME FROM CMODEL c, MAKE m WHERE c.MAKE_ID = m.MAKE_ID AND m.MAKE_NAME='".$make."'";
		$stmt = oci_parse($conn, $query);
		if(@oci_execute($stmt)) {
			while($row = oci_fetch_array($stmt)) {
				echo "<option>".$row["MODEL_NAME"]."</option>";
			}
		} else {
			echo "<option>Select a Make</option>";
		}
	} else {
		echo "<option>Select a Make</option>";
	}
?>