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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><br>
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
					<a class="navbar-brand" href="#">Ruthless Real Estate</a>
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
        
        (car_id numeric NN PK, rego_no character(8) NN, year numeric (4) NN, colour character (30) NN,
        odometer numeric NN, doors numeric (5) NN, seats numeric NN, engine_size numeric NN, cylinders
        numeric NN, car_thumbnail character (50), car_model numeric FK NN, body_type character(20) NN,
        car_transmission character(20) NN, fuel_type character(20) NN, drive_type character(20) NN)
        
        <?php 
		if (empty($_POST["rego_no"])) {
		?>
        <form method="post" enctype="multipart/form-data" action="vehicles.php">
        	<span>Registration number</span><input type="text" name="rego_no"> </input>
            <span>Year</span><input type="text" name="year"> </input>
            <span>Colour</span><input type="text" name="colour"> </input>
            <span>Odometer</span><input type="text" name="odometer"> </input>
            <span>Doors</span><input type="text" name="doors"> </input>
            <span>Seats</span><input type="number" name="seat_no" min="1" max="12" value="5" />
            <span>Engine Size</span><input type="number" name="engine_size" min="0" max="10" value="2" />
            <span>Cylinders</span><input type="number" name="cylinder_no" min="1" max="12" value="4" />
            <span>Car image</span><input type="file" name="image_1">
            <!--each time an image is uploaded, we add a new field to be able to add images again.-->
            <span>Make Name</span><select name="make_name">
            	<option>Dummy</option>
            </select>
            <span>Model Name</span><select name="model_name">
            	<option>Dummy</option>
            </select>
            <span>Body Type</span><select name="body_type">
            	<option value="blathiswillbeavailable" selected>Dummy</option>
            </select>
            <span>Transmission</span><select name="car_transmission">
            	<option value="Auto" selected>Auto</option>
                <option value="Manual" selected>Manual</option>
                <option value="Manual" selected>Sports</option>
            </select>
            <span>Fuel Type</span><select name="fuel_type">
            	<option value="Petrol" selected>Petrol</option>
            </select>
            
            
        </form>
        <?php
		} else {
					
		}
		?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>

</html> 



