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
		<h1>Features</h1>
		<table>
			<tr>
				<h3>
					<td>Feature ID</td>
					<td>Feature Name</td>
				</h3>
			</tr>
		</table>
		<?php
		$conn = oci_connect("s24222232", "monash00", "FIT2076") or die("Couldn't logon.");
		$query = "SELECT * FROM FEATURE ORDER BY FEATURE_ID";
		$stmt = oci_parse($conn, $query);
		
		while($row = oci_fetch_array($stmt)) {
			echo '<tr>';
			echo '<td>' . $row["FEATURE_ID"] . '</td>';
			echo '<td>' . $row["FEATURE_NAME"] . '</td>';
			echo '<td><a href="featureupdate.php?clientid=' . $row["FEATURE_ID"] . '&Action=Update">Update</a></td>';
			echo '<td><a href="featureupdate.php?clientid=' . $row["FEATURE_ID"] . '&Action=Delete">Delete</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>

</html> 



