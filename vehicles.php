<?php 
session_start(); 
ob_start();
include("phputils/logincheck.php");
include("phputils/conn.php");
include("phputils/helpers.php");
?>
<html>
	<head>
		<meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- mobile optimise the page. Set the width to follow the screen width of the device -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cyrils Classic Cars</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="libs/jquery-ui-1.11.4.custom/jquery-ui.min.css">
	<style>
		.tablebuttons {
			float:right;
			margin: 15px 10px 0px 0px;
			opacity: 0.5;
		}
		.submitButtons {
			padding-top: 10px;
			display:inline-block;
			margin: 0px 0px 0px 10px;
		}
		.edit {
			margin: 10px 10px 10px 0;
		}
		.delete {
			margin: 10px 0 10px 0;
		}
		.selected {
			border: 1px solid purple;
		}
		.clickable {
			opacity: 1;
		}
		.error {
			color: red;
			font-weight: bold;
		}
		h3 {
			display: inline-block;
		}
		.code {
			border-top: 1px solid black;
			width:100%;
		}
    </style>
	</head>

	<body>
		<nav class="jumbotron navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle"
					data-toggle="collapse" data-target="#myNavbar">
						<h3 class="icon-bar"></h3>
						<h3 class="icon-bar"></h3>
						<h3 class="icon-bar"></h3>
					</button>
					<a class="navbar-brand" href="#">Cyrils Classic Cars</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li class="active"><a href="vehicles.php">Vehicles</a></li>
						<li class="active"><a href="clients.php">Clients</a></li>
						<li class="active"><a href="makes.php">Makes</a></li>
						<li class="active"><a href="models.php">Models</a></li>
						<li class="active"><a href="features.php">Features</a></li>
						<li class="active"><a href="images.php">Images</a></li>
						<li class="active"><a href="logout.php">Log-out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h1>Manage Vehicles</h1>

		<div id="tabs">
		  <ul>
		    <li><a href="#fragment-1">Search Vehicles</a></li>
		    <li><a href="#fragment-2">Add Vehicle</a></li>
		  </ul>
		  <div id="fragment-1">
		  	<?php 
		  		if (!isset($_GET['Action'])) {
		  	?>
		  	<h2>Search for a Vehicle in the Database</h2>
		  	<form method="post" action="vehicles.php?Action=Search">
		  		<h3>Registration Number:</h3><input type="text" name="rego_no"></br>
		  		<h3>Make:</h3><input type="text" name="make_name"></br>
		  		<h3>Model:</h3><input type="text" name="model_name">
				<div class="submitbuttons">
					<input class="btn btn-lg btn-primary" type="button" value="All" onClick="window.location.href='vehicles.php?Action=SearchAll'">
            		<input class="btn btn-lg btn-primary" type="submit" value="Submit">
            		<input class="btn btn-lg btn-danger" type="Reset" value="Clear">
            	</div>
		  	</form>
		  	<?php 
		  		} else {
		  			switch($_GET["Action"]) {
		  				case "Search":
		  				case "SearchAll":
		  					if($_GET["Action"] == "Search") {
		  						$reg = strtoupper($_POST["rego_no"]);//LIKE is case sensitive. All our data is uppercase at insertion
		  						$make = strtoupper($_POST["make_name"]);
		  						$model = strtoupper($_POST["model_name"]);
			  					$query = "SELECT * FROM CAR WHERE CAR_REG LIKE '%".$reg."%' AND MAKE_ID IN (SELECT MAKE_ID FROM MAKE WHERE MAKE_NAME LIKE '%".$make."%') AND MODEL_ID IN (SELECT MODEL_ID FROM CMODEL WHERE MODEL_NAME LIKE '%".$model."%')";
				  				$stmt = oci_parse($conn, $query);
		  					} else {
		  						$query = "SELECT * FROM CAR";
			  					$stmt = oci_parse($conn, $query);
		  					}
		 	?>
			  	<table id="vehicles" class="display" cellspacing="0" width="100%">
				  	<thead>
				  		<th>Car ID</th>
				  		<th>Make</th>
				  		<th>Model</th>
				  		<th>Registration</th>
				  		<th>Body Type</th>
				  		<th>Transmission</th>
				  		<th>Year</th>
				  		<th>Colour</th>
				  		<th>Thumbnail</th>
				  	</thead>
				  	<tfoot>
				  		<th>Car ID</th>
				  		<th>Make</th>
				  		<th>Model</th>
				  		<th>Registration</th>
				  		<th>Body Type</th>
				  		<th>Transmission</th>
				  		<th>Year</th>
				  		<th>Colour</th>
				  		<th>Thumbnail</th>
				  	</tfoot>
				  	<?php 
				  		if(@oci_execute($stmt)) {
				  			while($row = oci_fetch_array($stmt)) 
				  			{
				  	?>
				  		<tr>
							<td><?php echo $row["CAR_ID"];?></td>
				  			<td><?php echo getMakeByID($row["MAKE_ID"], $conn)["MAKE_NAME"];?></td>
				  			<td><?php echo getModelByID($row["MODEL_ID"], $conn)["MODEL_NAME"];?></td>
				  			<td><?php echo $row["CAR_REG"];?></td>
				  			<td><?php echo $row["CAR_BODYTYPE"];?></td>
				  			<td><?php echo $row["CAR_TRANSMISSION"];?></td>
				  			<td><?php echo $row["CAR_YEAR"];?></td>
				  			<td><?php echo $row["CAR_COLOUR"];?></td>
				  			<td><!-- Car image thumbnail -->
				  				<?php
				  					$images = getCarImages($row["CAR_ID"]);
				  					if(sizeof($images) > 0) {
				  						$directory = "vehicle_images/".$row["CAR_ID"]."/".$images[2];
				  					} else {
				  						$directory = '';
				  					}
				  					// echo $directory;
				  					echo '<img src="' . $directory . '" width="80" height="80" alt="Car Image">';?>
				  			</td>
				  		</tr>
				  	<?php 
				  	} //end while
				  	?>
			  	</table>
				<div class="tablebuttons">
					<button class="edit btn btn-lg btn-primary" onClick="editVehicle();">Edit</button>
					<button class="delete btn btn-lg btn-danger" onClick="deleteVehicle();">Delete</button>
				</div>
				<button class="delete btn btn-lg btn-danger" onClick="window.location.href='vehicles.php'">Back</button>
			  	<?php 
			  	} else {//end if
			  		header("error.php?Reason=BackendError");
			  	}
			  	?>
		  	<?php
		  		break;
		  	case "Edit":
		  		$query = "SELECT c.CAR_ID, c.MAKE_ID, c.MODEL_ID, cm.MODEL_NAME, m.MAKE_NAME, c.CAR_REG, c.CAR_BODYTYPE, c.CAR_TRANSMISSION, ";
		  		$query = $query . "c.CAR_ODOMETER, c.CAR_YEAR, c.CAR_COLOUR, c.CAR_DOORS, c.CAR_SEATS, c.CAR_CYLINDERS, ";
		  		$query = $query . "c.CAR_ENGINESIZE, c.CAR_FUELTYPE, c.CAR_DRIVETYPE FROM CAR c, MAKE m, CMODEL cm ";
		  		$query = $query . "WHERE c.CAR_ID=".$_GET["Car_ID"]." AND c.MAKE_ID = m.MAKE_ID AND c.MODEL_ID = cm.MODEL_ID";
		  		$stmt = oci_parse($conn, $query);
		  		if(@oci_execute($stmt)) {
		  			$row = oci_fetch_array($stmt);
		  	?>
				<h2>Edit an existing vehicle</h2>
				<form method="post" enctype="multipart/form-data" action="vehicles.php?Action=EditConfirm">
					<?php echo "<input style='display: none' name='carid' value='".$_GET["Car_ID"]."'></input>";?>
		        	<h3>Registration number:</h3><input type="text" name="rego_no" value=<?php echo '"'.$row["CAR_REG"].'"';?> required></br>
		            <h3>Year:</h3><?php echo '<input type="number" name="year" min="1807" max="'.(date('Y') + 1).'" value="'.$row["CAR_YEAR"].'">'?><br>
		            <h3>Colour:</h3><input type="text" name="colour" value=<?php echo '"'.$row["CAR_COLOUR"].'"';?> required></br>
		            <h3>Odometer:</h3><input type="number" name="odometer" min="1" value=<?php echo '"'.$row["CAR_ODOMETER"].'"';?>></br>
		            <h3>Doors:</h3><input type="number" name="door_no" min="1" max="6" value=<?php echo '"'.$row["CAR_DOORS"].'"';?>></br>
		            <h3>Seats:</h3><input type="number" name="seat_no" min="1" max="15" value=<?php echo '"'.$row["CAR_SEATS"].'"';?>></br>
		            <h3>Engine Size:</h3><input type="number" name="engine_size" min="0" max="99" value=<?php echo '"'.$row["CAR_ENGINESIZE"].'"';?>></br>
		            <h3>Cylinders:</h3><input type="number" name="cylinder_no" min="1" max="12" value=<?php echo '"'.$row["CAR_CYLINDERS"].'"';?>></br>
		            <h3>Existing Images:</h3><br>
		            <span style="color:red; padding-left:15px;">Tick to remove</span>
		            <div class="existingimages">
	            	<?php 
	            		foreach(getCarImages($row["CAR_ID"]) as $image) 
	            		{
	            	?>
	            			<input type="checkbox" name=<?php echo '"'.$image.'"';?> value=<?php echo '"'.$image.'"';?>><img src=<?php echo '"vehicle_images/'.$row["CAR_ID"].'/'.$image.'"';?> width="200" height="200"><br>
	            	<?php 
	            		} //end for each 
	            	?>
	            	</div>
		            <h3>New images:</h3>
		            <a class='addimagefield editimagefield' href="javascript:void(0);" onClick="addImageField(this);">
		            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
		            </a>
		            <div class="imageinput editimagediv" id="file_1">
		            	<input type="file" accept="image/*" name="file_1"  onchange="showMyImage(this)"/>
						<img id="thumbnail_1" name="thumbnail_1" style="width:20%; margin-top:10px;"  src="" alt="image"/>
			            <a href="javascript:void(0);" onClick="removeImageField(this)">
			            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
			            </a>
		            </div>

		            <!--each time an image is uploaded, we add a new field to be able to add images again.-->
		            <h3>Make Name:</h3><select name="make_name" onChange="getModels(this.value)" required>
		            	<option value="">None</option>
		            	<?php 
		            		$query = "SELECT * FROM MAKE";
		            		$stmt = oci_parse($conn, $query);
		            		if(@oci_execute($stmt)) {
		            			while($makes = oci_fetch_array($stmt)) 
		            			{
									echo '<option value="'.$makes["MAKE_NAME"].'"' .fSelect($row["MAKE_ID"],$makes["MAKE_ID"]). '>';
									echo $makes["MAKE_NAME"];
									echo '</option>';
								}
		            	?>
		            	<?php 
		            	} else {
		            		header("error.php?Reason=BackendError");
		            	}
		            	?>
		            </select></br>
		            <h3>Model Name:</h3><select class="models" name="model_name" required>
		            	<option value="">None</option>
		            	<?php 
		            		$query = "SELECT * FROM CMODEL WHERE MAKE_ID=".$row["MAKE_ID"];
		            		$stmt = oci_parse($conn, $query);
		            		if(@oci_execute($stmt)) {
		            			while($models = oci_fetch_array($stmt)) 
		            			{
									echo '<option value="'.$models["MODEL_NAME"].'"' .fSelect($row["MODEL_ID"],$models["MODEL_ID"]). '>';
									echo $models["MODEL_NAME"];
									echo '</option>';
								}
		            	?>
		            	<?php 
		            	} else {
		            		header("error.php?Reason=BackendError");
		            	}
		            	?>
		            </select></br>
		            <h3>Body Type:</h3><select name="body_type" required>
		            	<option value="">None</option>
		            	<option value="Hatch" <?php echo fSelect("HATCH", $row["CAR_BODYTYPE"]);?>>Hatch</option>
		            	<option value="Sedan"<?php echo fSelect("SEDAN", $row["CAR_BODYTYPE"]);?>>Sedan</option>
		            	<option value="Wagon"<?php echo fSelect("WAGON", $row["CAR_BODYTYPE"]);?>>Wagon</option>
		            	<option value="Ute"<?php echo fSelect("UTE", $row["CAR_BODYTYPE"]);?>>Ute</option>
		            	<option value="SUV/4WD"<?php echo fSelect("SUV/4WD", $row["CAR_BODYTYPE"]);?>>4WD</option>
		            	<option value="Convertible"<?php echo fSelect("CONVERTIBLE", $row["CAR_BODYTYPE"]);?>>Convert</option>
		            	<option value="Other"<?php echo fSelect("OTHER", $row["CAR_BODYTYPE"]);?>>Other</option>
		            </select></br>
		            <h3>Transmission</h3><select name="car_transmission" required>
		            	<option value="">None</option>
		            	<option value="Auto" <?php echo fSelect("AUTO", $row["CAR_TRANSMISSION"]);?>>Auto</option>
		                <option value="Manual" <?php echo fSelect("MANUAL", $row["CAR_TRANSMISSION"]);?>>Manual</option>
		                <option value="Sports" <?php echo fSelect("SPORTS", $row["CAR_TRANSMISSION"]);?>>Sports</option>
		            </select></br>
		            <h3>Fuel Type</h3><select name="fuel_type" required>
		            	<option value="">None</option>
		            	<option value="Petrol" <?php echo fSelect("PETROL", $row["CAR_FUELTYPE"]);?>>Petrol</option>
		            	<option value="Diesel" <?php echo fSelect("DIESEL", $row["CAR_FUELTYPE"]);?>>Diesel</option>
		            	<option value="LPGas" <?php echo fSelect("LPGAS", $row["CAR_FUELTYPE"]);?>>LPGas</option>
		            	<option value="Other" <?php echo fSelect("OTHER", $row["CAR_FUELTYPE"]);?>>Other</option>
		            </select></br>
		            <h3>Drive Type</h3><select name="drive_type" required>
		            	<option value="">None</option>
		            	<option value="Front wheel drive" <?php echo fSelect("FRONT WHEEL DRIVE", $row["CAR_DRIVETYPE"]);?>>FWD</option>
		            	<option value="Rear wheel drive" <?php echo fSelect("REAR WHEEL DRIVE", $row["CAR_DRIVETYPE"]);?>>RWD</option>
		            	<option value="Four wheel drive" <?php echo fSelect("FOUR WHEEL DRIVE", $row["CAR_DRIVETYPE"]);?>>AWD</option>
		            	<option value="Other" <?php echo fSelect("OTHER", $row["CAR_DRIVETYPE"]);?>>Other</option>
		            </select></br>
		            <!-- <h3>Features</h3> Deprecated for now
		            <a class='addfeaturefield' href="javascript:void(0);" onClick="addFeatureField();">
		            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
		            </a>
		            <div class="featureinput">
						<select name="feature_name_1">
			            	<option>Select A Feature</option>
			            	<?php 
			            		//$query = "SELECT FEATURE_NAME FROM FEATURE";
			            		//$stmt = oci_parse($conn, $query);
			            		//if(@oci_execute($stmt)) {
			            		//	while($row = oci_fetch_array($stmt)) 
			            		//	{
			            	?>
			            	<option><?php //echo $row["FEATURE_NAME"];?></option>
			            	<?php 
			            	//	}
			            	//} else {
			            	//	header("error.php?Reason=BackendError");
			            	//}
			            	?>
			            </select>
			            <a href="javascript:void(0);" onClick="removeFeatureField(this)">
			            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
			            </a>
		            </div> -->
    	            
		            <div class="submitButtons">
						<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
		            	<input class="btn btn-lg btn-info" type="Reset" Value="Clear">
		            	<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='vehicles.php'">
		            </div>
		        </form>
		    <?php
		    } else {
		    	header("error.php?Reason=BackendError");
		    }//end oci exec
		    	break;
		    case "EditConfirm":
		    	$query = "UPDATE CAR SET MAKE_ID=:mkid, MODEL_ID=:moid, CAR_REG=:creg, CAR_ODOMETER=:codom, CAR_YEAR=:cyear, CAR_DRIVETYPE=:cdrive, CAR_BODYTYPE=:cbod, CAR_COLOUR=:ccolor, CAR_TRANSMISSION=:ctran,"; 
		    	$query = $query . " CAR_FUELTYPE=:cfuel, CAR_SEATS=:cseat, CAR_DOORS=:cdoor, CAR_ENGINESIZE=:cengin, CAR_CYLINDERS=:ccylin WHERE CAR_ID=".$_POST["carid"];
		    	$stmt = oci_parse($conn, $query);
		    	foreach(getCarImages($_POST["carid"]) as $image) {
		    		//php replaces name such as img.png with img_png
		    		//we have to work around this
		    		$postimg = str_split($image, strlen($image)-4); //subtract standard windows extension length
		    		// print_r($postimg);
		    		$postimg = $postimg[0] . '_' . explode(".", $postimg[1], 2)[1];
		    		// echo $postimg;
		    		if(isset($_POST[$postimg])) {
		    			removeImage($_POST["carid"], $image);
		    		} else {
		    			//do nothing
		    		}
		    	}
				foreach($_FILES as $image) {
					// specify a directory name for permanent storage
					// we're going to leave the filename as it was on client machine
					if (!file_exists('vehicle_images/'.$_POST["carid"])) {
					    mkdir('vehicle_images/'.$_POST["carid"], 0777, true);
					}

					if(isset($image["name"]) & strlen($image["name"]) > 0) {//if image field empty
						$upfile = "vehicle_images/".$_POST["carid"]."/".$image["name"];
						// this does the work
						//moved the uploaded file from temporary location to permanent storage
						//location
						//if this doesn't work an error message is displayed
						if(!move_uploaded_file($image["tmp_name"],$upfile)) {
							header("location: vehicles.php?Action=EditFail");
						}
					} else {
						//do nothing its an empty field
					}
					
				}
				$mkid = intval(getMakeIDByName($_POST["make_name"], $conn));
	            $moid = intval(getModelIDByName($_POST["model_name"], $conn));
	            $creg = strtoupper($_POST["rego_no"]);
	            $cbod = strtoupper($_POST["body_type"]);
	            $codom = intval($_POST["odometer"]);
	            $ctran = strtoupper($_POST["car_transmission"]);
	            $cyear = intval($_POST["year"]);
	            $ccolor = strtoupper($_POST["colour"]);
	            $cdoor = intval($_POST["door_no"]);
	            $cseat = intval($_POST["seat_no"]);
	            $ccylin = intval($_POST["cylinder_no"]);
	            $cengin = intval($_POST["engine_size"]);
	            $cfuel = strtoupper($_POST["fuel_type"]);
	            $cdrive = strtoupper($_POST["drive_type"]);

                oci_bind_by_name($stmt, ":mkid", $mkid);
				oci_bind_by_name($stmt, ":moid", $moid);
				oci_bind_by_name($stmt, ":creg", $creg);
				oci_bind_by_name($stmt, ":cbod", $cbod);
				oci_bind_by_name($stmt, ":ctran", $ctran);	
				oci_bind_by_name($stmt, ":codom", $codom);
				oci_bind_by_name($stmt, ":cyear", $cyear);
				oci_bind_by_name($stmt, ":ccolor", $ccolor);
				oci_bind_by_name($stmt, ":cdoor", $cdoor);
				oci_bind_by_name($stmt, ":cseat", $cseat);
				oci_bind_by_name($stmt, ":ccylin", $ccylin);
				oci_bind_by_name($stmt, ":cengin", $cengin);
				oci_bind_by_name($stmt, ":cfuel", $cfuel);
				oci_bind_by_name($stmt, ":cdrive", $cdrive);

				if(@oci_execute($stmt)) {
            		echo '<h2>Record Edited successfully</h2></br>';
            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="vehicles.php">';
				} else {
					header("location: vehicles.php?Action=EditFail");
				}
				break;
			case "Delete":
				$query = "SELECT * FROM CAR WHERE CAR_ID=".$_GET["Car_ID"];
				$stmt = oci_parse($conn, $query);
				if(@oci_execute($stmt)) {
					$car = oci_fetch_array($stmt);
				} else {
					header("error.php?Reason=BackendError");
				}
			?>
				<h2>The record you are deleting:</h2>
            	<form method="post" action="vehicles.php?Action=DeleteConfirm">
            		<input style="display:none;" type="text" name="carid" value=<?php echo '"'.$_GET["Car_ID"].'"'?>>
                	<h3>ID#:</h3><span><?php echo $_GET["Car_ID"];?></span><br>
                	<h3>Make:</h3><?php echo getMakeByID($car["MAKE_ID"], $conn)["MAKE_NAME"];?></span><br>
                	<h3>Model:</h3><?php echo getModelByID($car["MODEL_ID"], $conn)["MODEL_NAME"];?></span><br>
                	<h3>Registration:</h3><?php echo $car["CAR_REG"];?></span><br>
                	<h3>Body:</h3><?php echo $car["CAR_BODYTYPE"];?></span><br>
                	<h3>Year:</h3><?php echo $car["CAR_YEAR"];?></span><br>
                	<h3>Images:</h3><br>
                	<span style="color:red; padding-left:15px">All images will be deleted</span><br>
					<?php 
	            		foreach(getCarImages($_GET["Car_ID"]) as $image) 
	            		{
	            	?>
	            			<img src=<?php echo '"vehicle_images/'.$_GET["Car_ID"].'/'.$image.'"';?> width="200" height="200"><br>
	            	<?php 
	            		} //end for each 
	            	?>
                	<div class="submitbuttons">
                		<input class="btn btn-lg btn-primary" type="submit" value="Delete">
                		<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='vehicles.php'">
                	</div>
                </form>
			<?php
				break;
			case "DeleteConfirm":
				foreach(getCarImages($_POST["carid"]) as $image) {
					removeImage($_POST["carid"], $image);
				}
				removeFolder($_POST["carid"]);

        		$query = "DELETE FROM CAR WHERE CAR_ID=".$_POST["carid"];
				$stmt = oci_parse($conn,$query);
				if (@oci_execute($stmt)) {
					echo '<h2>Record Deleted</h2>';
					echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="vehicles.php">';
				}
				else {
					echo '<h2 class="error">Deletion Failed</h2>';	
					echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="vehicles.php">';
				}
				break;	
			case "EditFail":
				echo '<h2 class="error">Unable to edit record</h2></br>';
        		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="vehicles.php">';
        		break;
		  	case "AddSuccess":
        		echo '<h2>Record Added successfully</h2></br>';
        		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="vehicles.php">';
        		break;
          	case "AddFail":
        		echo '<h2 class="error">Unable to add record</h2></br>';
        		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="vehicles.php">';
           		break;
            	} //end switch
		  	} //end else 
		  	?>
		  </div>

		  <div id="fragment-2">
		  	<?php 
		  		if (!isset($_GET['Action']) || $_GET['Action'] != "Add") {
		  	?>
		  	<h2>Add a new vehicle to the database</h2>
			<form method="post" enctype="multipart/form-data" action="vehicles.php?Action=Add">
	        	<h3>Registration number:</h3><input type="text" name="rego_no" required></br>
	            <h3>Year:</h3><?php echo '<input type="number" name="year" min="1807" max="'.(date('Y') + 1).'" value="'.date('Y').'">'?><br>
	            <h3>Colour:</h3><input type="text" name="colour" required></br>
	            <h3>Odometer:</h3><input type="number" name="odometer" min="1" value="10000"></br>
	            <h3>Doors:</h3><input type="number" name="door_no" min="1" max="6" value="4"></br>
	            <h3>Seats:</h3><input type="number" name="seat_no" min="1" max="15" value="5"></br>
	            <h3>Engine Size:</h3><input type="number" name="engine_size" min="0" max="99" value="10"></br>
	            <h3>Cylinders:</h3><input type="number" name="cylinder_no" min="1" max="12" value="4"></br>
	            <h3>Car image:</h3>
	            <a class='addimagefield newimagefield' href="javascript:void(0);" onClick="addImageField(this);">
	            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
	            </a>
	            <div class="imageinput newimagediv" id="file_1">
	            	<input type="file" accept="image/*" name="file_1"  onchange="showMyImage(this)"/>
					<img id="thumbnail_1" name="thumbnail_1" style="width:20%; margin-top:10px;"  src="" alt="image"/>
		            <a href="javascript:void(0);" onClick="removeImageField(this)">
		            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
		            </a>
	            </div>

	            <!--each time an image is uploaded, we add a new field to be able to add images again.-->
	            <h3>Make Name</h3><select name="make_name" onChange="getModels(this.value)" required>
	            	<option value="">None</option>
	            	<?php 
	            		$query = "SELECT MAKE_NAME FROM MAKE";
	            		$stmt = oci_parse($conn, $query);
	            		if(@oci_execute($stmt)) {
	            			while($row = oci_fetch_array($stmt)) 
	            			{
	            	?>
	            	<option><?php echo $row["MAKE_NAME"];?></option>
	            	<?php 
	            		}
	            	} else {
	            		header("error.php?Reason=BackendError");
	            	}
	            	?>
	            </select></br>
	            <h3>Model Name</h3><select class="models" name="model_name" required>
	            	<option value="">Select A Make</option>
	            </select></br>
	            <h3>Body Type</h3><select name="body_type" required>
	            	<option value="">None</option>
	            	<option value="Hatch">Hatch</option>
	            	<option value="Sedan">Sedan</option>
	            	<option value="Wagon">Wagon</option>
	            	<option value="Ute">Ute</option>
	            	<option value="SUV/4WD">4WD</option>
	            	<option value="Convertible">Convert</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <h3>Transmission</h3><select name="car_transmission" required>
	            	<option value="">None</option>
	            	<option value="Auto">Auto</option>
	                <option value="Manual">Manual</option>
	                <option value="Sports">Sports</option>
	            </select></br>
	            <h3>Fuel Type</h3><select name="fuel_type" required>
	            	<option value="">None</option>
	            	<option value="Petrol">Petrol</option>
	            	<option value="Diesel">Diesel</option>
	            	<option value="LPGas">LPGas</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <h3>Drive Type</h3><select name="drive_type" required>
	            	<option value="">None</option>
	            	<option value="Front wheel drive">FWD</option>
	            	<option value="Rear wheel drive">RWD</option>
	            	<option value="Four wheel drive">AWD</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <!-- <h3>Features</h3>
	            <a class='addfeaturefield' href="javascript:void(0);" onClick="addFeatureField();">
	            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
	            </a>
	            <div class="featureinput">
					<select name="feature_name_1">
		            	<option>Select A Feature</option>
		            	<?php 
		            		//$query = "SELECT FEATURE_NAME FROM FEATURE";
		            		//$stmt = oci_parse($conn, $query);
		            		//if(@oci_execute($stmt)) {
		            		//	while($row = oci_fetch_array($stmt)) 
		            		//	{
		            	?>
		            	<option><?php //echo $row["FEATURE_NAME"];?></option>
		            	<?php 
		            	//	}
		            	//} else {
		            	//	header("error.php?Reason=BackendError");
		            	//}
		            	?>
		            </select>
		            <a href="javascript:void(0);" onClick="removeFeatureField(this)">
		            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
		            </a>
	            </div> -->

	            <div class="submitButtons">
					<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
	            	<input class="btn btn-lg btn-info" type="Reset" Value="Clear">
	            </div>
	        </form>
		  </div>
		</div>
	     
        <?php
		} else {

        	$query2 = "SELECT SEQ_CAR_ID.nextval FROM DUAL";
            $stmt2 = oci_parse($conn, $query2);
            if(@oci_execute($stmt2)) {
            	$cid = oci_fetch_array($stmt2)["NEXTVAL"];
            } else {
            	header("location: vehicles.php?Action=AddFail");
            }

			$query = "INSERT INTO CAR (CAR_ID, MAKE_ID, MODEL_ID, CAR_REG, CAR_BODYTYPE, CAR_TRANSMISSION, CAR_ODOMETER, CAR_YEAR,";
			$query = $query . "CAR_COLOUR, CAR_DOORS, CAR_SEATS, CAR_CYLINDERS, CAR_ENGINESIZE, CAR_FUELTYPE, CAR_DRIVETYPE)";
			$query = $query . "VALUES (:cid, :mkid, :moid, :creg, :cbod, :ctran, :codom, :cyear, :ccolor, :cdoor, :cseat, :ccylin, :cengin, :cfuel, :cdrive)";


            $stmt = oci_parse($conn,$query);
            $mkid = intval(getMakeIDByName($_POST["make_name"], $conn));
            $moid = intval(getModelIDByName($_POST["model_name"], $conn));
            $creg = strtoupper($_POST["rego_no"]);
            $cbod = strtoupper($_POST["body_type"]);
            $codom = intval($_POST["odometer"]);
            $ctran = strtoupper($_POST["car_transmission"]);
            $cyear = intval($_POST["year"]);
            $ccolor = strtoupper($_POST["colour"]);
            $cdoor = intval($_POST["door_no"]);
            $cseat = intval($_POST["seat_no"]);
            $ccylin = intval($_POST["cylinder_no"]);
            $cengin = intval($_POST["engine_size"]);
            $cfuel = strtoupper($_POST["fuel_type"]);
            $cdrive = strtoupper($_POST["drive_type"]);


			if (!file_exists('vehicle_images/'.$cid)) {
			    mkdir('vehicle_images/'.$cid, 0777, true);
			}

			foreach($_FILES as $image) {
				// specify a directory name for permanent storage
				// we're going to leave the filename as it was on client machine
				$upfile = "vehicle_images/".$cid."/".$image["name"];
				// this does the work
				//moved the uploaded file from temporary location to permanent storage
				//location
				//if this doesn't work an error message is displayed
				if(!move_uploaded_file($image["tmp_name"],$upfile)) {
					header("location: vehicles.php?Action=AddFail");
				}
			}
            oci_bind_by_name($stmt, ":cid", $cid);
            oci_bind_by_name($stmt, ":mkid", $mkid);
			oci_bind_by_name($stmt, ":moid", $moid);
			oci_bind_by_name($stmt, ":creg", $creg);
			oci_bind_by_name($stmt, ":cbod", $cbod);
			oci_bind_by_name($stmt, ":ctran", $ctran);	
			oci_bind_by_name($stmt, ":codom", $codom);
			oci_bind_by_name($stmt, ":cyear", $cyear);
			oci_bind_by_name($stmt, ":ccolor", $ccolor);
			oci_bind_by_name($stmt, ":cdoor", $cdoor);
			oci_bind_by_name($stmt, ":cseat", $cseat);
			oci_bind_by_name($stmt, ":ccylin", $ccylin);
			oci_bind_by_name($stmt, ":cengin", $cengin);
			oci_bind_by_name($stmt, ":cfuel", $cfuel);
			oci_bind_by_name($stmt, ":cdrive", $cdrive);
            if(@oci_execute($stmt)) {
            	header("location: vehicles.php?Action=AddSuccess");
            } else {
            	header("location: vehicles.php?Action=AddFail");
            }
		}
		?>
		<div class="code">
			<a href="phputils/displaysource.php?filename=vehicles.php" target="_blank">
				<img src="assets/vehicle.png">
			</a>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
	    	$(function() {
	    		$( "#tabs" ).tabs();
	  		});
			$(document).ready(function(){
			    $('#vehicles').DataTable();
			});
			$(document).on('click', 'tr', function () {
	  			$('tr').removeClass('selected');
		        $(this).addClass('selected');
		        $('.tableButtons').addClass('clickable');
	  		});
			function editVehicle () {
				var rowcol1 = $('tr.selected td:first-child');
				if (rowcol1) {
					//pass the makeid and name as its more efficient, less coupled
					window.location.href = "vehicles.php?Action=Edit&Car_ID=" + rowcol1[0].innerHTML;
				}
			};
			function deleteVehicle () {
				var rowcol1 = $('tr.selected td:first-child');
				if (rowcol1) {
					//pass the makeid and name as its more efficient, less coupled
					window.location.href = "vehicles.php?Action=Delete&Car_ID=" + rowcol1[0].innerHTML;
				}
			};

	  		function showMyImage (fileInput) {
		        var files = fileInput.files;
		        for (var i = 0; i < files.length; i++) {           
		            var file = files[i];
		            var imageType = /image.*/;     
		            if (!file.type.match(imageType)) {
		                continue;
		            }           
		            countfile = fileInput.getAttribute("name").slice(-1);
		            var img=document.getElementById("thumbnail_" + countfile);            
		            img.file = file;    
		            var reader = new FileReader();
		            reader.onload = (function(aImg) { 
		                return function(e) { 
		                    aImg.src = e.target.result; 
		                }; 
		            })(img);
		            reader.readAsDataURL(file);
		        }    
		    };
			function addImageField (field) {
				if('addimagefield editimagefield' == $(field).attr('class')) {//need to be able to distinguish between tabs
					var lastfile = $('.editimagediv').last();
					var countfile = ($('.editimagediv').length)+1;
					var classcopy = "imageinput editimagediv";
					var selector = ".editimagediv";
				} else {
				    var lastfile = $('.newimagediv').last();
				    var countfile = ($('.newimagediv').length)+1;
				    var classcopy = "imageinput newimagediv";
				    var selector = ".newimagediv";
				}

			    if(lastfile.length == 0) {
			    	lastfile = field;
			    }

			    $("<div>", {
			    	"class": classcopy,
			    	"id": "file_"+countfile
			    }).insertAfter(lastfile);

			    $( "<input/>", {
			        "type": "file",
			        "accept": "image/*",
			        "name": "file_"+countfile,
			        "id": "file_"+countfile,
			        "onchange": "showMyImage(this)"
			    }).appendTo($(selector).last());

			    $("</br>").appendTo($(selector).last());
			    
			    $( "<img/>", {
			    	"id": "thumbnail_" +countfile,
			    	"name": "thumbnail_"+countfile,
			    	"style": "width:20%; margin-top:10px;",
			    	"src": "",
			    	"alt": "image"
			    }).appendTo($(selector).last());

			    $('<a href="javascript:void(0);" onClick="removeImageField(this);"><img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png"></a>').appendTo($(selector).last());
			};
			function removeImageField (field) {
				field.closest('.imageinput').remove();
			};
			function getModels(makename) {
				$.ajax({
					url: "getModels.php?Make_Name=" + makename, 
					success: function (result) {
						$(".models").empty();
       					$(".models").html(result);
					}
				});
			}
			function addFeatureField (field) {
				/**
					Deprecated as the spec doesnt specify features on the vehicle page
				**/
				var lastfeature = $('.featureinput').last();
				var countfeature = ($('.featureinput').length)+1;

			    if(lastfeature.length == 0) {
			    	lastfeature = field;
			    }

			    featureField = $('.featureinput').first();
			    if(featureField.length == 0) {
			    	featureField = $(".addfeaturefield").data();
			    	$(featureField.outerHTML).insertAfter(lastfeature);
			    } else {
		    		featureField.clone().insertAfter(lastfeature);
			    }
			    lastfeature = $('.featureinput select').last();
			    var newName = lastfeature.attr("name");
			    lastfeature.attr("name", "feature_name_"+countfeature);
			}
			function removeFeatureField (field) {
				/**
					Deprecated as the spec doesnt specify features on the vehicle page
				**/
				var countfeature = ($('.featureinput').length);
				if(countfeature == 1) {//we need to save the feature field to save the features or not have to load them again
					$(".addfeaturefield").data(field.closest('.featureinput'));
				}
				field.closest('.featureinput').remove();
			}
    	</script>
	</body>

</html>