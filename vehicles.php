<?php 
session_start(); 
ob_start();
include("phputils/logincheck.php");
include("phputils/conn.php");

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

function firstImageFn() {
	return 'neckbeard.jpg';
}


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
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
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
		<h1>This is the vehicles page</h1>

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
		  			//echo "WTFBBQ";
		  			switch($_GET["Action"]) {
		  				case "Search" || "SearchAll":
		  					if($_GET["Action"] == "Search") {
			  					$query = "SELECT * FROM CAR WHERE CAR_REG LIKE '%".$_POST["rego_no"]."%' AND MAKE_ID IN (SELECT MAKE_ID FROM MAKE WHERE MAKE_NAME LIKE '%".$_POST["make_name"]."%') AND MODEL_ID IN (SELECT MODEL_ID FROM CMODEL WHERE MODEL_NAME LIKE '%".$_POST["model_name"]."%')";
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
			  				<?php //echo '<img src="vehicle_images/'.$row["CAR_REG"].'/'.firstImageFn().'" width="80" height="80">';?>
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
		  		break;
		  	case "AddSuccess":
            		echo '<h2>Record Added successfully</h2></br>';
            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="makes.php">';
        		break;
          	case "AddFail":
            		echo '<h2 class="error">Unable to add record</h2></br>';
            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="makes.php">';
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
	        	<span>Registration number</span><input type="text" name="rego_no" required></br>
	            <span>Year</span><?php echo '<input type="number" name="year" min="1807" max="'.(date('Y') + 1).'" value="'.date('Y').'">'?><br>
	            <span>Colour</span><input type="text" name="colour" required></br>
	            <span>Odometer</span><input type="number" name="odometer" min="1" value="10000"></br>
	            <span>Doors</span><input type="number" name="door_no" min="1" max="6" value="4"></br>
	            <span>Seats</span><input type="number" name="seat_no" min="1" max="15" value="5"></br>
	            <span>Engine Size</span><input type="number" name="engine_size" min="0" max="99" value="10"></br>
	            <span>Cylinders</span><input type="number" name="cylinder_no" min="1" max="12" value="4"></br>
	            <span>Car image</span>
	            <a class='addimagefield' href="javascript:void(0);" onClick="addImageField();">
	            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
	            </a>
	            <div class="imageinput" id="file_1">
	            	<input type="file" accept="image/*" name="file_1"  onchange="showMyImage(this)"/>
					<img id="thumbnail_1" name="thumbnail_1" style="width:20%; margin-top:10px;"  src="" alt="image"/>
		            <a href="javascript:void(0);" onClick="removeImageField(this)">
		            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
		            </a>
	            </div>

	            <!--each time an image is uploaded, we add a new field to be able to add images again.-->
	            <span>Make Name</span><select name="make_name" onChange="getModels(this.value)" required>
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
	            <span>Model Name</span><select class="models" name="model_name" required>
	            	<option value="">Select A Make</option>
	            </select></br>
	            <span>Body Type</span><select name="body_type" required>
	            	<option value="">None</option>
	            	<option value="Hatch">Hatch</option>
	            	<option value="Sedan">Sedan</option>
	            	<option value="Wagon">Wagon</option>
	            	<option value="Ute">Ute</option>
	            	<option value="SUV/4WD">4WD</option>
	            	<option value="Convertible">Convert</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <span>Transmission</span><select name="car_transmission" required>
	            	<option value="">None</option>
	            	<option value="Auto">Auto</option>
	                <option value="Manual">Manual</option>
	                <option value="Sports">Sports</option>
	            </select></br>
	            <span>Fuel Type</span><select name="fuel_type" required>
	            	<option value="">None</option>
	            	<option value="Petrol">Petrol</option>
	            	<option value="Diesel">Diesel</option>
	            	<option value="LPGas">LPGas</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <span>Drive Type</span><select name="drive_type" required>
	            	<option value="">None</option>
	            	<option value="Front wheel drive">FWD</option>
	            	<option value="Rear wheel drive">RWD</option>
	            	<option value="Four wheel drive">AWD</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <span>Features</span>
	            <a class='addfeaturefield' href="javascript:void(0);" onClick="addFeatureField();">
	            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
	            </a>
	            <div class="featureinput">
					<select name="feature_name_1">
		            	<option>Select A Feature</option>
		            	<?php 
		            		$query = "SELECT FEATURE_NAME FROM FEATURE";
		            		$stmt = oci_parse($conn, $query);
		            		if(@oci_execute($stmt)) {
		            			while($row = oci_fetch_array($stmt)) 
		            			{
		            	?>
		            	<option><?php echo $row["FEATURE_NAME"];?></option>
		            	<?php 
		            		}
		            	} else {
		            		header("error.php?Reason=BackendError");
		            	}
		            	?>
		            </select>
		            <a href="javascript:void(0);" onClick="removeFeatureField(this)">
		            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
		            </a>
	            </div>
	            
	            <div class="submitButtons">
					<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
	            	<input class="btn btn-lg btn-info" type="Reset" Value="Clear">
	            </div>
	        </form>
		  </div>
		</div>
	     
        <?php
		} else {
			// // specify a directory name for permanent storage
			// // we're going to leave the filename as it was on client machine
			// $upfile = "vehicle_images/".$_POST["rego_no"]."/".$_FILES["image_1"]["name"];
			// // this does the work
			// //moved the uploaded file from temporary location to permanent storage
			// //location
			// //if this doesn't work an error message is displayed
			// if(!move_uploaded_file($_FILES["image_1"] ["tmp_name"],$upfile))
			// {
			//  echo "ERROR: Could Not Move File into Directory";
			// }
			// //if it does work some information about the file is displayed to the user
			// else
			// {
			//  echo "Temporary File Name: " .$_FILES["image_1"] ["tmp_name"]."<br />";
			//  echo "File Name: " .$_FILES["image_1"]["name"]. "<br />";
			//  echo "File Size: " .$_FILES["image_1"]["size"]. "<br />";
			//  echo "File Type: " .$_FILES["image_1"]["type"]. "<br />"; 
			// }
			$query = "INSERT INTO CAR (CAR_ID, MAKE_ID, MODEL_ID, CAR_REG, CAR_BODYTYPE, CAR_TRANSMISSION, CAR_ODOMETER, CAR_YEAR,";
			$query = $query . "CAR_COLOUR, CAR_DOORS, CAR_SEATS, CAR_CYLINDERS, CAR_ENGINESIZE, CAR_FUELTYPE, CAR_DRIVETYPE)";
			$query = $query . "VALUES (SEQ_CAR_ID.nextval, :mkid, :moid, :creg, :cbod, :ctran, :codom, :cyear, :ccolor, :cdoor, :cseat, :ccylin, :cengin, :cfuel, :cdrive)";
            // print_r($_POST);
            // echo sizeof($_POST);
            // foreach($_POST as $value) {
            // 	echo $value . " " . gettype($value) . "</br>";
            // }
            // echo getMakeIDByName($_POST["make_name"], $conn). "type: ". gettype(getMakeIDByName($_POST["make_name"], $conn));
            // $mkid = intval(getMakeIDByName($_POST["make_name"], $conn));
            // $moid = intval(getModelIDByName($_POST["model_name"], $conn));
            // echo $mkid ."</br>";
            // echo $moid;
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
            if(oci_execute($stmt)) {
            	header("location: vehicles.php?Action=AddSuccess");
            } else {
            	header("location: vehicles.php?Action=AddFail");
            }
		}
		?>

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
	  			console.log(fileInput);
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
			function addImageField () {
			    var lastfile = $('.imageinput').last();
			    var countfile = ($('.imageinput').length)+1;
			    if(lastfile.length == 0) {
			    	lastfile = $('.addimagefield');
			    }

			    $("<div>", {
			    	"class": "imageinput",
			    	"id": "file_"+countfile
			    }).insertAfter(lastfile);

			    $( "<input/>", {
			        "type": "file",
			        "accept": "image/*",
			        "name": "file_"+countfile,
			        "id": "file_"+countfile,
			        "onchange": "showMyImage(this)"
			    }).appendTo($('.imageinput').last());

			    $("</br>").appendTo($('.imageinput').last());
			    
			    $( "<img/>", {
			    	"id": "thumbnail_" +countfile,
			    	"name": "thumbnail_"+countfile,
			    	"style": "width:20%; margin-top:10px;",
			    	"src": "",
			    	"alt": "image"
			    }).appendTo($('.imageinput').last());

			    $('<a href="javascript:void(0);" onClick="removeImageField(this);"><img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png"></a>').appendTo($('.imageinput').last());
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
			function addFeatureField () {
				var lastfeature = $('.featureinput').last();
				var countfeature = ($('.featureinput').length)+1;
			    if(lastfeature.length == 0) {
			    	lastfeature = $('.addfeaturefield');
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
				var countfeature = ($('.featureinput').length);
				if(countfeature == 1) {//we need to save the feature field to save the features or not have to load them again
					$(".addfeaturefield").data(field.closest('.featureinput'));
				}
				field.closest('.featureinput').remove();
			}
    	</script>
	</body>

</html>