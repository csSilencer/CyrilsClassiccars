<?php 
session_start(); 
ob_start();
include("phputils/logincheck.php");
?>
<html>
	<head>
		<meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- mobile optimise the page. Set the width to follow the screen width of the device -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cyrils Classic Cars</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="libs/jquery-ui-1.11.4.custom/jquery-ui.min.css">
	<style>
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
		  		if (!isset($_GET['Action']) || $_GET['Action'] != "Search") {
		  	?>
		  	<h2>Search for a Vehicle in the Database</h2>
		  	<form method="post" action="vehicles.php?Action=Search">
		  		<span>Registration Number</span><input type="text" name="rego_no"></br>
		  		<span>Make</span><input type="text" name="make_name"></br>
		  		<span>Model</span><input type="text" name="model_name"></br>
		  		<input type="submit" value="Submit">
	            <input type="Reset" value="Reset">
		  	</form>
		  	<?php 
		  		} else {
		  			echo "<p>".print_r($_POST)."</p>";
		  		}
		  	?>
		  </div>

		  <div id="fragment-2">
		  	<?php 
		  		if (!isset($_GET['Action']) || $_GET['Action'] != "Add") {
		  	?>
		  	<h2>Add a new vehicle to the database</h2>
			<form method="post" enctype="multipart/form-data" action="vehicles.php?Action=Add">
	        	<span>Registration number</span><input type="text" name="rego_no"></br>
	            <span>Year</span><input type="text" name="year"></br>
	            <span>Colour</span><input type="text" name="colour"></br>
	            <span>Odometer</span><input type="text" name="odometer"></br>
	            <span>Doors</span><input type="number" name="door_no" min="1" max="12" value="5"></br>
	            <span>Seats</span><input type="number" name="seat_no" min="1" max="12" value="5"></br>
	            <span>Engine Size</span><input type="number" name="engine_size" min="0" max="10" value="2"></br>
	            <span>Cylinders</span><input type="number" name="cylinder_no" min="1" max="12" value="4"></br>
	            <span>Car image</span>
	            <a href="javascript:void(0);" onClick="addField();">
	            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
	            </a>
	            <a href="javascript:void(0);" onClick="removeField">
	            	<img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
	            </a>

	            <input type="file" accept="image/*" name="file_1"  onchange="showMyImage(this)"/>
				<img id="thumbnail_1" name="thumbnail_1" style="width:20%; margin-top:10px;"  src="" alt="image"/>

	            <!--each time an image is uploaded, we add a new field to be able to add images again.-->
	            <span>Make Name</span><select name="make_name">
	            	<option>Dummy</option>
	            </select></br>
	            <span>Model Name</span><select name="model_name">
	            	<option>Dummy</option>
	            </select></br>
	            <span>Body Type</span><select name="body_type">
	            	<option value="Hatch">Hatch</option>
	            	<option value="Sedan">Sedan</option>
	            	<option value="Wagon">Wagon</option>
	            	<option value="Ute">Ute</option>
	            	<option value="SUV/4WD">SUV/4WD</option>
	            	<option value="Convertible">Convertible</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <span>Transmission</span><select name="car_transmission">
	            	<option value="Auto">Auto</option>
	                <option value="Manual">Manual</option>
	                <option value="Sports">Sports</option>
	            </select></br>
	            <span>Fuel Type</span><select name="fuel_type">
	            	<option value="Petrol">Petrol</option>
	            	<option value="Diesel">Diesel</option>
	            	<option value="LPGas">LPGas</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <span>Drive Type</span><select name="drive_type">
	            	<option value="Front wheel drive">Front wheel drive</option>
	            	<option value="Rear wheel drive">Rear wheel drive</option>
	            	<option value="Four wheel drive">Four wheel drive</option>
	            	<option value="Other">Other</option>
	            </select></br>
	            <input type="submit" value="Submit">
	            <input type="Reset" value="Reset">
	        </form>
		  </div>
		</div>
	     
        <?php
		} else {
			// specify a directory name for permanent storage
			// we're going to leave the filename as it was on client machine
			$upfile = "vehicle_images/".$_POST["rego_no"]."/".$_FILES["image_1"]["name"];
			// this does the work
			//moved the uploaded file from temporary location to permanent storage
			//location
			//if this doesn't work an error message is displayed
			if(!move_uploaded_file($_FILES["image_1"] ["tmp_name"],$upfile))
			{
			 echo "ERROR: Could Not Move File into Directory";
			}
			//if it does work some information about the file is displayed to the user
			else
			{
			 echo "Temporary File Name: " .$_FILES["image_1"] ["tmp_name"]."<br />";
			 echo "File Name: " .$_FILES["image_1"]["name"]. "<br />";
			 echo "File Size: " .$_FILES["image_1"]["size"]. "<br />";
			 echo "File Type: " .$_FILES["image_1"]["type"]. "<br />"; 
			}
		}
		?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
    	$(function() {
    		$( "#tabs" ).tabs();
  		});

  		function showMyImage(fileInput) {
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
	    }
		function addField(){
		    var lastfile = $('form input:file').last();
		    var countfile = ($('form input:file').length)+1;
		    $( "<input/>", {
		        "type": "file",
		        "accept": "image/*",
		        "name": "file_"+countfile,
		        "id": "file_"+countfile,
		        "onchange": "showMyImage(this)"
		    }).insertAfter(lastfile);

		    $("</br>").insertAfter($('form input:file').last());
		    
		    $( "<img/>", {
		    	"id": "thumbnail_" +countfile,
		    	"name": "thumbnail_"+countfile,
		    	"style": "width:20%; margin-top:10px;",
		    	"src": "",
		    	"alt": "image"
		    }).insertAfter($('form input:file').last());
		}
    	</script>
	</body>

</html>