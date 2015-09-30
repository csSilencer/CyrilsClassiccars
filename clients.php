<?php 
session_start(); 
ob_start();
include("phputils/logincheck.php");
include("phputils/conn.php");
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
		<style type="text/css">
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
		<h1>Clients</h1>

		<?php 
			$query= "SELECT * FROM CLIENT";
			$stmt = oci_parse($conn, $query);
			if(!oci_execute($stmt)) {
				echo "<center style='color: red;'><h1>Failed to connect to the database<h1></center>";
				echo "<center style='color: red;'><h2>Try refreshing<h2></center>";
			}
		?>

		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">View Clients</a></li>
				<li><a href="#tabs-2">Add Client</a></li>
				<li><a href="#tabs-3">Send E-mail</a></li>
			</ul>

		  <div id="tabs-1">

		  	<?php 
				if(isset($_GET["Action"])) 
				{
					switch($_GET["Action"])
					{
						case "Edit":
							/* insert code here */
						break;

		  				case "DeleteConfirm":
							/* drop constraints */
							$q1 = "ALTER TABLE CLIENT DISABLE CONSTRAINT CLIENT_PK";
		            		$query = "DELETE FROM CLIENT WHERE CLIENT_ID=".$_POST["clientid"];
							$q2 - "ALTER TABLE CLIENT ENABLE CONSTRAINT CLIENT_PK";
							$s1 = oci_parse($conn, $q1);
							$stmt = oci_parse($conn,$query);
							$s2 = oci_parse($conn, $q2);
							oci_execute($s1);
							if (@oci_execute($stmt)) {
								oci_execute($s2);
								echo '<h2>Record Deleted</h2>';
								echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
							}
							else {
								oci_execute($s2);
								echo '<h2 class="error">Deletion Failed</h2>';	
								echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
							}
						break;
						
		            	case "AddSuccess":
		            		echo '<h2>Record Added successfully</h2></br>';
		            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
		            	break;
		            	
		            	case "AddFail":
		            		echo '<h2 class="error">Unable to add record</h2></br>';
		            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
		            	break;
						
						case "EmailSuccess":
							echo '<h2>Email sent</h2><br />';
							echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
						break;
						
						case "EmailFail":
		            		echo '<h2 class="error">Email unsuccessful</h2></br>';
		            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
		            	break;
						
						default:
							header("location: clients.php");	  	
				  		break;
		  			}
		  		}
		  	
		  	
		  		if(!isset($_GET["Action"])) 
		  		{

		  	?>
				<table id="clients" class="display" cellspacing="0" width="100%">
					<thead>
						<td>ID</td>
						<td>Given Name</td>
						<td>Surname</td>
						<td>Address</td>
						<td>Phone</td>
						<td>Mobile</td>
						<td>Email</td>
						<td>Mailing List</td>
					</thead>

					<tfoot>
						<td>ID</td>
						<td>Given Name</td>
						<td>Surname</td>
						<td>Address</td>
						<td>Phone</td>
						<td>Mobile</td>
						<td>Email</td>
						<td>Mailing List</td>
					</tfoot>
					<tbody>
						<?php 
							while($row = oci_fetch_array($stmt))
							{
						?>
						<tr>
							<td><?php echo $row[0]; ?></td>
							<td><?php echo $row[1]; ?></td>
							<td><?php echo $row[2]; ?></td>
							<td><?php echo $row[3]; ?></td>
							<td><?php echo $row[4]; ?></td>
							<td><?php echo $row[5]; ?></td>
							<td><?php echo $row[6]; ?></td>
							<td><?php echo $row[7]; ?></td>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
				<div class="tablebuttons">
					<button class="edit btn btn-lg btn-primary" onClick="editClient();">Edit</button>
					<button class="delete btn btn-lg btn-danger" onClick="deleteClient();">Delete</button>
				</div>
		  </div>
		  	<?php 
		  	}
		  	?>
		  <div id="tabs-2">

		  	<h2>Insert a new Client</h2>
		  	<?php
		  	if (!isset($_GET['Action']) || $_GET['Action'] != "Add")
			{
		    ?>
	        	<form method="get" name="insertform" action="clients.php?Action=Add">
					<p>Given Name <input type="text" name="givenname"></p>
					<p>Surname <input type="text" name="familyname"></p>
					<p>Address <input type="text" name="address"></p>
					<p>Phone <input type="text" name="phone"></p>
					<p>Mobile <input type="text" name="mobile"></p>
					<p>Email <input type="text" name="email"></p>
					<p>Mailing List <select name="mailinglist">
						<option>Y</option>
						<option>N</option>
					</select></p>
		            <div class="submitButtons">
						<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
		            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
		            </div>
	            </form>      
		    <?php
		    	} else {
		                $query = "INSERT INTO CLIENT VALUES(SEQ_CLIENT_ID.NEXTVAL, :gn, :fn, :add, :ph, :mob, :em, :ml)";
		                //$query = "INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, " . $test . ", 'TEST', 'TEST', 'TEST', 'TEST', 'TEST', 'Y')";
						$stmt = oci_parse($conn, $query);
						$gn = $_POST["givenname"];
						$fn = $_POST["familyname"];
						$add = $_POST["address"];
						$ph = $_POST["phone"];
						$mob = $_POST["mobile"];
						$em = $_POST["email"];
						$ml = $_POST["mailinglist"];
					
						oci_bind_by_name($stmt, ":gn", $gn);
						oci_bind_by_name($stmt, ":fn", $fn);
						oci_bind_by_name($stmt, ":add", $add);
						oci_bind_by_name($stmt, ":ph", $ph);
						oci_bind_by_name($stmt, ":mob", $mob);
						oci_bind_by_name($stmt, ":em", $em);
						oci_bind_by_name($stmt, ":ml", $ml);
						
		                if(@oci_execute($stmt)) {
		                	header("location: clients.php?Action=AddSuccess");
		                } else {
		                	header("location: clients.php?Action=AddFail");
		                	echo $query;
		                }
		            }
		        
		        ?>
		  </div>
			<div id="tabs-3">
				<?php
					if (!isset($_GET['Action']) || $_GET['Action'] != "Email")
					{
						echo '<form method="post" name="emailform" action="clients.php?Action=Email"';
						$query = "SELECT CLIENT_EMAIL FROM CLIENT WHERE CLIENT_MAILINGLIST='Y'";
						$stmt = oci_parse($conn, $query);
						oci_execute($stmt);
						echo '<p>To: ';
						echo '<select name="to">';
						while ($names = oci_fetch_array($stmt))
						{
							echo '<option value="'.$names["CLIENT_EMAIL"].'">';
							echo $names["CLIENT_EMAIL"];
							echo '</option>';
						}
						echo '</select>';
						echo '</p>';
						echo '<p>Subject: <input type="text" name="subject"></p>';
						echo '<p>Message: <textarea cols="68" name="message" rows="9"></textarea></p>';
						echo '<input type="Submit" value="Submit"><br />';
						echo '<input type="Reset" value="Clear"><br />';
						echo '</form>';
					} else {
						$from = "From: Cyril's Classic Cars <cyril.crook@cyrilsclassiccars.com.au>";
						$to = $_POST["to"];
						$msg = $_POST["message"];
						$subject = $_POST["subject"];
						if(mail($to, $subject, $msg, $from))
						{
							header("location: clients.php?Action=EmailSuccess");							
						} else {
							header("location: clients.php?Action=EmailFail");
		                	echo $from.$to.$msg.$subject;
						}
					}
				
				?>
			</div>
			
		</div>		

		<div class="code">
			<a href="phputils/displaysource.php?filename=clients.php">
				<img src="assets/client.png">
			</a>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$("input").prop('required',true);
			$(document).ready(function(){
			    $('#clients').DataTable();
			});
			$(function() {
	    		$( "#tabs" ).tabs();
	  		});
	  		$(document).on('click', 'tr', function () {
	  			$('tr').removeClass('selected');
		        $(this).addClass('selected');
		        $('.tableButtons').addClass('clickable');
	  		});
			// function editMake() {
			// 	var rowcol1 = $('tr.selected td:first-child');
			// 	var rowcol2 = $('tr.selected td:last-child');
			// 	if (rowcol1) {
			// 		//pass the makeid and name as its more efficient, less coupled
			// 		window.location.href = "makes.php?Action=Edit&Make_ID=" + rowcol1[0].innerHTML + "&Make_Name=" + rowcol2[0].innerHTML;
			// 	}
			// };
			
			/*
			function deleteClient() {
			 	var rowcol1 = $('tr.selected td:first-child');
			 	var rowcol2 = $('tr.selected td:last-child');
			 	if (rowcol1) {
			 		//pass the clientid and name as its more efficient, less coupled
			 		//window.location.href = "makes.php?Action=Delete&Client_ID=" + rowcol1[0].innerHTML + "&Make_Name=" + rowcol2[0].innerHTML;
			 	}
			 };
			 */
		</script>

	</body>

</html> 



