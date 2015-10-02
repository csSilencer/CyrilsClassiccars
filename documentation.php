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
	</head>
	<style type="text/css">
	</style>

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
					<a class="navbar-brand" href="#">Cyril's Classic Cars</a>
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
		<h1>Documentation</h1>
		<h2>FIT2076 Assignment 2</h2>
		<h2>Submitted 2nd October 2015</h2>
		<h2>Supporting Documentation</h2>
		<h3>Authors:</h3><span>Ivan Ristov (25115782) iris2@student.monash.edu 
			and Martin Dulics (24222232) mdul2@student.monash.edu</span>
		<h3>Connection details:</h3><span>Username: s24222232; Password: monash00. Alternatively, this is the $conn variable $conn = oci_connect("s24222232","monash00","FIT2076") or die("Couldn't logon.");</span>
		<h3>Database creation file:</h3><a href="sqlscripts/createtables.txt" download>Download Table Creation File</a>
		<h3>Data In DB/Test Data at time of submission:</h3><a href="sqlscripts/testdata.txt" download>Download Test Data</a>
		<h3>Member Contribution:</h3><a href="documentation/Project-Completion-Details.docx" download>Download Work Breakdown</a>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>

</html> 



