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
		<h1>Clients</h1>
		<table>
			<tr>
				<h3>
					<td>ID</td>
					<td>Given Name</td>
					<td>Surname</td>
					<td>Address</td>
					<td>Phone</td>
					<td>Mobile</td>
					<td>Email</td>
				</h3>
			</tr>
		</table>
		
		<?php
		$conn = oci_connect("s24222232", "monash00", "FIT2076") or die("Couldn't logon.");
		$query = "SELECT * FROM CLIENT ORDER BY CLIENT_ID";
		$stmt = oci_parse($conn, $query);
		
		while ($row = oci_fetch_array($stmt)) {
			echo '<tr>';
			echo '<td>' . $row["CLIENT_ID"] . '</td>';
			echo '<td>' . $row["CLIENT_GIVENNAME"] . '</td>';
			echo '<td>' . $row["CLIENT_FAMILYNAME"] . '</td>';
			echo '<td>' . $row["CLIENT_ADDRESS"] . '</td>';
			echo '<td>' . $row["CLIENT_PHONE"] . '</td>';
			echo '<td>' . $row["CLIENT_MOBILE"] . '</td>';
			//need email integration
			echo '<td>' . $row["CLIENT_EMAIL"] . '</td>';
			echo '<td><a href="clientupdate.php?clientid=' . $row["CLIENT_ID"] . '&Action=Update">Update</a></td>';
			echo '<td><a href="clientupdate.php?clientid=' . $row["CLIENT_ID"] . '&Action=Delete">Delete</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		
		if (empty($_POST["clientid"]))
		{
			?>
			<form method="post" Action="clients.php">
				<h2>Insert a new Client</h2>
				<p>Client ID: <?php echo $_POST["clientid"] ?></p>
				<p>Given Name <input type="text" name="givenname"</p>
				<p>Surname <input type="text" name="familyname"</p>
				<p>Address <input type="text" name="address"</p>
				<p>Phone <input type="text" name="phone"</p>
				<p>Mobile <input type="text" name="mobile"</p>
				<p>Email <input type="text" name="email"</p>
				<input type="Submit" value="Submit">
				<input type="Reset" value="Clear">
			</form>
			<?php
		}
		else {
			$query = "INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, :gn, :fn, :add, :ph, :mob, :em)";
			$stmt = oci_parse($conn, $query);
			
			$p1 = $_POST["givenname"];
			$p2 = $_POST["familyname"];
			$p3 = $_POST["address"];
			$p4 = $_POST["phone"];
			$p5 = $_POST["mobile"];
			$p6 = $_POST["email"];
			oci_bind_by_name($stmt, ":gn", $p1);
			oci_bind_by_name($stmt, ":fn", $p2);
			oci_bind_by_name($stmt, ":add", $p3);
			oci_bind_by_name($stmt, ":ph", $p4);
			oci_bind_by_name($stmt, ":mob", $p5);
			oci_bind_by_name($stmt, ":em", $p6);
			
			if (@oci_execute($stmt)) {
				echo '<p>Insert successful</p>';
			} else {
				echo '<p>Insert failed</p>';
			}
			
			/* Refresh the page */
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		
		/* add client button as indicated in spec */
		// <img src="">
		?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>

</html> 



