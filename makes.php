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
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="libs/jquery-ui-1.11.4.custom/jquery-ui.min.css">
		<style type="text/css">
			.buttons {
				float:right;
				margin: 15px 10px 0px 0px;
				opacity: 0.5;
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
			.btnsubmit {
				margin: 0px 10px 0px 0px;
			}
			.newmakesubmit {
				padding-top: 10px;
				display:inline-block;
				margin: 0px 0px 0px 10px;
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
		<?php 
			$conn = oci_connect("s25115782","monash00","fit2076");
			// echo "<p>". $conn ."</p>";
			$query= "SELECT * FROM MAKE";
			$stmt = oci_parse($conn, $query);
			if(!oci_execute($stmt)) {
				echo "<center style='color: red;'><h1>Failed to connect to the database<h1></center>";
				echo "<center style='color: red;'><h2>Try refreshing<h2></center>";
			}
		?>

		<div id="tabs">
		  <ul>
		    <li><a href="#tabs-1">Existing Makes</a></li>
		    <li><a href="#tabs-2">New Make</a></li>
		  </ul>
			<div id="tabs-1">
			  	<h2>Edit/Delete a Make</h2>
				<table id="makes" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>MakeID</th>
			                <th>MakeName</th>
			            </tr>
			        </thead>
			 
			        <tfoot>
			            <tr>
							<th>MakeID</th>
			                <th>MakeName</th>
			            </tr>
			        </tfoot>

			        <tbody>
			        	<?php 
			        		while ($row = oci_fetch_array ($stmt)) {
			        	?>
			        	<tr>
			        		<td><?php echo $row[0]; ?></td>
			        		<td><?php echo $row[1]; ?></td>
			        	</tr>
			        	<?php } ?>
			        </tbody>
				</table>
				<div class="buttons">
					<button class="edit btn btn-lg btn-primary" onClick="editMake();">Edit</button>
					<button class="delete btn btn-lg btn-danger" onClick="deleteMake();">Delete</button>
				</div>
			  </div>
			<div id="tabs-2">
				<h2>Insert a new make</h2>
		        <?php 
		        	if (!isset($_GET["Action"]) || $_GET['Action'] !="Add")
		        	{
		        ?>
	        	<form method="post" action="makes.php?Action=Add">
	            <span>Make name</span><input type="text" name="makename">
	            <div class="newmakesubmit">
					<input class="btnsubmit btn btn-lg btn-primary" type="Submit" Value="Submit">
	            	<input class="btnclear btn btn-lg btn-info"type="Reset" Value="Clear">
	            </div>
	            
		        <?php 
		    		} else {
		                $conn = oci_connect("s25115782","monash00","fit2076") or die("Couldn't logon.");
		                $mn = $_POST["makename"];
		                $query="INSERT INTO MAKE (MAKE_ID, MAKE_NAME) VALUES (make_seq.nextval,:mname)";
		                $stmt = oci_parse($conn, $query);
		                oci_bind_by_name($stmt, ":mname", $mn);
		                if(oci_execute($stmt)) {
		                	header("location: makes.php?Action=AddSuccess");
		                } else {
		                	header("location: makes.php?Action=AddFail");
		                }
		            }
		        ?>
		    </div>
		</div>

	  	

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		    $('#makes').DataTable();
		});
		$(function() {
    		$( "#tabs" ).tabs();
  		});

		$(function() {
		    $('tr').on('click', function() {
		    	$('tr').removeClass('selected');
		        $(this).addClass('selected');
		        $('.buttons').addClass('clickable');
		    });
		});
		function editMake() {
			var row = $('tr.selected td:first-child');
			if (row) {
				window.location.href = "makes.php?Action=Edit&Make_ID=" + row[0].innerHTML;
			}
		};
		function deleteMake() {
			var row = $('tr.selected td:first-child');
			if (row) {
				window.location.href = "makes.php?Action=Delete&Make_ID=" + row[0].innerHTML;
			}
		};
		</script>
	</body>

</html> 



