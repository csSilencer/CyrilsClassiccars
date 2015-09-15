<?php 
session_start(); 
ob_start();
include("logincheck.php");
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
    	input { 
			display:block;
			}
		select {
			display: block;
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
        
        <?php 
		if (empty($_POST["rego_no"])) {
		?>

		<div id="tabs">
		  <ul>
		    <li><a href="#fragment-1">Search Vehicles</a></li>
		    <li><a href="#fragment-2">Add Vehicle</a></li>
		  </ul>
		  <div id="fragment-1">
		  	<h2>Search for a Vehicle in the Database</h2>
		  </div>

		  <div id="fragment-2">
		  	<h2>Add a new vehicle to the database</h2>
			<form method="post" enctype="multipart/form-data" action="vehicles.php">
	        	<span>Registration number</span><input type="text" name="rego_no">
	            <span>Year</span><input type="text" name="year">
	            <span>Colour</span><input type="text" name="colour">
	            <span>Odometer</span><input type="text" name="odometer">
	            <span>Doors</span><input type="number" name="door_no" min="1" max="12" value="5">
	            <span>Seats</span><input type="number" name="seat_no" min="1" max="12" value="5">
	            <span>Engine Size</span><input type="number" name="engine_size" min="0" max="10" value="2">
	            <span>Cylinders</span><input type="number" name="cylinder_no" min="1" max="12" value="4">
	            <span>Car image</span><input type="file" name="image_1">
	            <!--each time an image is uploaded, we add a new field to be able to add images again.-->
	            <span>Make Name</span><select name="make_name">
	            	<option>Dummy</option>
	            </select>
	            <span>Model Name</span><select name="model_name">
	            	<option>Dummy</option>
	            </select>
	            <span>Body Type</span><select name="body_type">
	            	<option value="Hatch">Hatch</option>
	            	<option value="Sedan">Sedan</option>
	            	<option value="Wagon">Wagon</option>
	            	<option value="Ute">Ute</option>
	            	<option value="SUV/4WD">SUV/4WD</option>
	            	<option value="Convertible">Convertible</option>
	            	<option value="Other">Other</option>
	            </select>
	            <span>Transmission</span><select name="car_transmission">
	            	<option value="Auto">Auto</option>
	                <option value="Manual">Manual</option>
	                <option value="Sports">Sports</option>
	            </select>
	            <span>Fuel Type</span><select name="fuel_type">
	            	<option value="Petrol">Petrol</option>
	            	<option value="Diesel">Diesel</option>
	            	<option value="LPGas">LPGas</option>
	            	<option value="Other">Other</option>
	            </select>
	            <span>Drive Type</span><select name="drive_type">
	            	<option value="Front wheel drive">Front wheel drive</option>
	            	<option value="Rear wheel drive">Rear wheel drive</option>
	            	<option value="Four wheel drive">Four wheel drive</option>
	            	<option value="Other">Other</option>
	            </select>
	            <input type="submit" value="Submit">
	            <input type="Reset" value="Reset">
	        </form>
		  </div>
		</div>
	     
        <?php
		} else {
			print_r($_POST);	
		}
		?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
    	$(function() {
    		$( "#tabs" ).tabs();
  		});
    	</script>
	</body>

</html> 



