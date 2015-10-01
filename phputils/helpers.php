<?php
	function fSelect ($value1, $value2) {
		$strSelect = "";
		if($value1 == $value2) {
			$strSelect = " SELECTED";
		}
		return $strSelect;
	}
	function getModelByID($id, $conn) {
		$query = "SELECT MODEL_NAME FROM CMODEL WHERE MODEL_ID=".$id;
		$stmt = oci_parse($conn, $query);
		if(@oci_execute($stmt)) {
			return oci_fetch_array($stmt);
		} else {
			return "unable to fetch";
		}
	}
	function getMakeByID($id, $conn) {
		$query = "SELECT MAKE_NAME FROM MAKE WHERE MAKE_ID=".$id;
		$stmt = oci_parse($conn, $query);
		if(@oci_execute($stmt)) {
			return oci_fetch_array($stmt);
		} else {
			return "unable to fetch";
		}
	}
	function getMakeIDByName($name, $conn) {
		$query = "SELECT MAKE_ID FROM MAKE WHERE MAKE_NAME='".$name."'";
		$stmt = oci_parse($conn, $query);
		if(@oci_execute($stmt)) {
			return oci_fetch_array($stmt)["MAKE_ID"];
		} else {
			return "unable to fetch";
		}
	}
	function getModelIDByName($name, $conn) {
		$query = "SELECT MODEL_ID FROM CMODEL WHERE MODEL_NAME='".$name."'";
		$stmt = oci_parse($conn, $query);
		if(@oci_execute($stmt)) {
			return oci_fetch_array($stmt)["MODEL_ID"];
		} else {
			return "unable to fetch";
		}
	}
	function getCarImages($rego_no) {
		$directory = 'vehicle_images/'.$rego_no;
		if (file_exists($directory)) {
			$scanned_directory = array_diff(scandir($directory), array('..', '.'));
			return $scanned_directory;
		}
		return Array();
	}
?>