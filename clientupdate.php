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
		<script language="javascript"> function confirm_delete() {
			window.location='t7_1b.php?clientid=<?php echo $_GET["modelid"]; ?>&Action=ConfirmDelete';
		}</script>

		<?php
		$conn = oci_connect("s24222232","monash00","FIT2076") or die("Couldn't logon.");
		$query = "SELECT * FROM CLIENT WHERE CLIENT_ID =".$_GET["clientid"];
		$stmt = oci_parse($conn, $query);
		oci_execute($stmt);
		$clientarray = oci_fetch_array($stmt);
		
		switch ($_GET["Action"])
		{
			case "Update": 
				?>
				<h1>Update Client</h1>
				<p>Client ID: <?php echo $clientarray["CLIENT_ID"] ?></p>
				<p>Given Name <input type="text" name="givenname" value="<?php echo $clientarray["CLIENT_GIVENNAME"] ?>"</p>
				<p>Surname <input type="text" name="familyname" value="<?php echo $clientarray["CLIENT_FAMILYNAME"] ?>"</p>
				<p>Address <input type="text" name="address" value="<?php echo $clientarray["CLIENT_ADDRESS"] ?>"</p>
				<p>Phone <input type="text" name="phone" value="<?php echo $clientarray["CLIENT_PHONE"] ?>"</p>
				<p>Mobile <input type="text" name="mobile" value="<?php echo $clientarray["CLIENT_MOBILE"] ?>"</p>
				<p>Email <input type="text" name="email" value="<?php echo $clientarray["CLIENT_EMAIL"] ?>"</p>
				<input type="Submit" value="Submit">
				<input type="Reset" value="Clear">
				<input type="button" value="Cancel" onclick=window.location="clients.php">
				</form>
				<?php
		}

		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>

</html> 



