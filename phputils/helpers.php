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
	function getCarImages($car_id) {
		$directory = 'vehicle_images/'.$car_id;
		if (file_exists($directory)) {
			$scanned_directory = array_diff(scandir($directory), array('..', '.'));
			return $scanned_directory;
		}
		return Array();
	}
	function removeImage($car_id, $image) {
		$file = 'vehicle_images/'.$car_id.'/'.$image;
		if (file_exists($file)) {
			unlink($file);
		} else {
			//do nothing;
		}
	}
	function removeFolder($car_id) {
		$file = 'vehicle_images/'.$car_id;
		if (is_dir($file)) {
			rmdir($file);
		} else {
			//do nothing;
		}
	}
	function getMakeByName ($makename, $conn) {
		$query = "SELECT * FROM MAKE WHERE MAKE_NAME='".$makename."'";
		$stmt = oci_parse($conn,$query);
		oci_execute($stmt);
		return oci_fetch_array($stmt);
	}
	//takes a y/n value and spits out html options for dropdown
	function mailingListFn($yn) {
		if($yn == 'Y') {
			return '<option value="Y" selected>Y</option>' . '<option value="N">N</option>';
		} else {
			return '<option value="N" selected>N</option>' . '<option value="Y">Y</option>';
		}
	}
?>