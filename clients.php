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
		  </ul>
		  <div id="tabs-1">

		  	<?php 
				if(isset($_GET["Action"])) {
					switch($_GET["Action"]){
						case "Edit":
		  	?>
		  	<h2>The record you are modifying:</h2>
        	<form method="post" action="clients.php?Action=EditConfirm">
        		<?php 
        		$query= "SELECT * FROM CLIENT WHERE CLIENT_ID=".$_GET["Client_ID"];
				$stmt = oci_parse($conn, $query);
				oci_execute($stmt);
				$client = oci_fetch_array($stmt);

        		echo '<h3>Given Name:</h3><input type="text" name="givenname" value="'.$client["CLIENT_GIVENNAME"].'"><br>';
				echo '<h3>Surname:</h3><input type="text" name="familyname" value="'.$client["CLIENT_FAMILYNAME"].'"><br>';
				echo '<h3>Address:</h3><input type="text" name="address" value="'.$client["CLIENT_ADDRESS"].'"><br>';
				echo '<h3>Phone:</h3><input type="text" name="phone" value="'.$client["CLIENT_PHONE"].'"><br>';
				echo '<h3>Mobile:</h3><input type="text" name="mobile" value="'.$client["CLIENT_MOBILE"].'"><br>';
				echo '<h3>Email:</h3><input type="text" name="email" value="'.$client["CLIENT_EMAIL"].'"><br>';
        		?>
	            <div class="submitButtons">
					<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
	            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
	            </div>
            </form>
		  	<?php 
		  		break;
		  	?>
		  	<?php 
				case "EditConfirm":
					print_r($_POST);
            		// $query = "UPDATE CLIENT SET CLIENT_GIVENNAME = CLIENT_FAMILYNAME CLIENT_ADDRESS CLIENT_PHONE CLIENT_MOBILE CLIENT_EMAIL";
	             //    $stmt = oci_parse($conn,$query);
	             //    if (oci_execute($stmt)) {
	             //        echo "<h2>The following make record has been successfully updated</h2></br>";
	             //        echo "<h3>Make name:</h3>".$_POST["makename"];
	             //        echo "</br>";
	             //        echo "<h3>Make ID:</h3>".$_POST["makeid"];
	             //    } else {
	             //        echo "<h2 class='error'>Error updating make record</h2>";
	             //    }
	                echo "<input class='btn btn-lg btn-primary submitButtons' type='button' value='Return to List' OnClick='window.location=\"clients.php\"'>";
	                break;
		  	?>
		  	<?php 
            	case "Delete":
            ?>
	            	<h2>The record you are deleting:</h2>
	            	<form method="post" action="clients.php?Action=DeleteConfirm">

	                	<?php
	                		$query = "SELECT * FROM CLIENT WHERE CLIENT_ID=".$_GET["Client_ID"];
	                		$stmt = oci_parse($conn,$query);
	                		oci_execute($stmt);
	                		$row = oci_fetch_array($stmt);
	                		echo '<input style="display:none;" type="text" name="clientid" value="'.$_GET["Client_ID"].'">'
	                	?>
	                	<h3>Client ID:</h3><?php echo $row[0];?><br>
						<h3>Given Name:</h3><?php echo $row[1];?><br>
						<h3>Surname:</h3><?php echo $row[2];?><br>
						<h3>Address:</h3><?php echo $row[3];?><br>
						<h3>Phone:</h3><?php echo $row[4];?><br>
						<h3>Mobile:</h3><?php echo $row[5];?><br>
						<h3>Email:</h3><?php echo $row[6];?>

	                	<div class="submitbuttons">
	                		<input class="btn btn-lg btn-primary" type="submit" value="Delete">
	                		<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='clients.php'">
	                	</div>
	                </form>
            <?php 
            	break;
            ?>
		  	<?php 
		  		case "DeleteConfirm":
            		$query = "DELETE FROM CLIENT WHERE CLIENT_ID=".$_POST["clientid"];
					$stmt = oci_parse($conn,$query);
					if (oci_execute($stmt)) {
						echo '<h2>Record Deleted</h2>';
						echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
					}
					else {
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
				default:
					header("location: clients.php");	  	
		  	?>

		  	<?php 
		  		break;
		  		}
		  	}
		  	?>
		  	<?php 
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
					</thead>

					<tfoot>
						<td>ID</td>
						<td>Given Name</td>
						<td>Surname</td>
						<td>Address</td>
						<td>Phone</td>
						<td>Mobile</td>
						<td>Email</td>
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
	        	if (!isset($_GET["Action"]) || $_GET['Action'] !="Add")
		        	{
		        ?>
	        	<form method="post" action="clients.php?Action=Add">
					<h3>Given Name:</h3><input type="text" name="givenname"><br>
					<h3>Surname:</h3><input type="text" name="familyname"><br>
					<h3>Address:</h3><input type="text" name="address"><br>
					<h3>Phone:</h3><input type="text" name="phone"><br>
					<h3>Mobile:</h3><input type="text" name="mobile"><br>
					<h3>Email:</h3><input type="text" name="email">
		            <div class="submitButtons">
						<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
		            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
		            </div>
	            </form>
		        <?php 
		    		} else {
		                $query = "INSERT INTO CLIENT (CLIENT_ID, CLIENT_GIVENNAME, CLIENT_FAMILYNAME, CLIENT_ADDRESS, CLIENT_PHONE, CLIENT_MOBILE, CLIENT_EMAIL) VALUES(SEQ_CLIENT_ID.NEXTVAL, :gn, :fn, :add, :ph, :mob, :em)";
						$stmt = oci_parse($conn, $query);
						$gn = $_POST["givenname"];
						$fn = $_POST["familyname"];
						$add = $_POST["address"];
						$ph = $_POST["phone"];
						$mob = $_POST["mobile"];
						$em = $_POST["email"];
						oci_bind_by_name($stmt, ":gn", $gn);
						oci_bind_by_name($stmt, ":fn", $fn);
						oci_bind_by_name($stmt, ":add", $add);
						oci_bind_by_name($stmt, ":ph", $ph);
						oci_bind_by_name($stmt, ":mob", $mob);
						oci_bind_by_name($stmt, ":em", $em);
		                if(oci_execute($stmt)) {
		                	header("location: clients.php?Action=AddSuccess");
		                } else {
		                	header("location: clients.php?Action=AddFail");
		                }
		            }
		        ?>
		  </div>
		</div>		
		<?php
		// $conn = oci_connect("s24222232", "monash00", "FIT2076") or die("Couldn't logon.");
		// $query = "SELECT * FROM CLIENT ORDER BY CLIENT_ID";
		// $stmt = oci_parse($conn, $query);
		// oci_execute($stmt);
		// while ($row = oci_fetch_array($stmt)) {
		// 	echo '<tr>';
		// 	echo '<td>' . $row["CLIENT_ID"] . '</td>';
		// 	echo '<td>' . $row["CLIENT_GIVENNAME"] . '</td>';
		// 	echo '<td>' . $row["CLIENT_FAMILYNAME"] . '</td>';
		// 	echo '<td>' . $row["CLIENT_ADDRESS"] . '</td>';
		// 	echo '<td>' . $row["CLIENT_PHONE"] . '</td>';
		// 	echo '<td>' . $row["CLIENT_MOBILE"] . '</td>';
		// 	//need email integration
		// 	echo '<td>' . $row["CLIENT_EMAIL"] . '</td>';
		// 	echo '<td><a href="clientupdate.php?clientid=' . $row["CLIENT_ID"] . '&Action=Update">Update</a></td>';
		// 	echo '<td><a href="clientupdate.php?clientid=' . $row["CLIENT_ID"] . '&Action=Delete">Delete</a></td>';
		// 	echo '</tr>';
		// }
		// echo '</table>';
		
		// if (empty($_POST["clientid"]))
		// {
			?>
<!-- 			<form method="post" Action="clients.php">
				<h2>Insert a new Client</h2>
				<p>Given Name <input type="text" name="givenname"</p>
				<p>Surname <input type="text" name="familyname"</p>
				<p>Address <input type="text" name="address"</p>
				<p>Phone <input type="text" name="phone"</p>
				<p>Mobile <input type="text" name="mobile"</p>
				<p>Email <input type="text" name="email"</p>
				<input type="Submit" value="Submit">
				<input type="Reset" value="Clear">
			</form> -->

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
			function editClient() {
				var rowcol1 = $('tr.selected td:first-child');
				if (rowcol1) {
					//pass the makeid and name as its more efficient, less coupled
					window.location.href = "clients.php?Action=Edit&Client_ID=" + rowcol1[0].innerHTML;
				}
			};
			function deleteClient() {
				var rowcol1 = $('tr.selected td:first-child');
				if (rowcol1) {
					//pass the makeid and name as its more efficient, less coupled
					window.location.href = "clients.php?Action=Delete&Client_ID=" + rowcol1[0].innerHTML;
				}
			};
		</script>

	</body>

</html> 



