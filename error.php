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

		<h1 style="color:red margin:auto">An unidentified backend error Has Occurred</h1>
		<h2 style="margin:auto">Click a tab to return to a page</h2>

	  	

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

		

	</body>

</html> 



