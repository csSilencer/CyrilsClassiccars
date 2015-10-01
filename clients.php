<?php 
session_start(); 
ob_start();
include("phputils/logincheck.php");
include("phputils/conn.php");
//takes a y/n value and spits out html options for dropdown
function mailingListFn($yn) {
	if($yn == 'Y') {
		return '<option value="Y" selected>Y</option>' . '<option value="N">N</option>';
	} else {
		return '<option value="N" selected>N</option>' . '<option value="Y">Y</option>';
	}
}

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
			?>
							<h2>The record you are modifying:</h2>
				        	<form method="post" action="clients.php?Action=EditConfirm">
				        		<?php 
				        		$query= "SELECT * FROM CLIENT WHERE CLIENT_ID=".$_GET["Client_ID"];
								$stmt = oci_parse($conn, $query);
								oci_execute($stmt);
								$client = oci_fetch_array($stmt);
								//send the client id over post
								echo "<input style='display: none' name='clientid' value='".$_GET["Client_ID"]."'></input>";
				        		echo '<h3>Given Name:</h3><input type="text" name="givenname" value="'.$client["CLIENT_GIVENNAME"].'" required><br>';
								echo '<h3>Surname:</h3><input type="text" name="familyname" value="'.$client["CLIENT_FAMILYNAME"].'" required><br>';
								echo '<h3>Address:</h3><input type="text" name="address" value="'.$client["CLIENT_ADDRESS"].'" required><br>';
								echo '<h3>Phone:</h3><input type="text" name="phone" value="'.$client["CLIENT_PHONE"].'" pattern="[0-9]*" required><br>';
								echo '<h3>Mobile:</h3><input type="text" name="mobile" value="'.$client["CLIENT_MOBILE"].'" pattern="[0-9]*" required><br>';
								echo '<h3>Email:</h3><input type="email" name="email" value="'.$client["CLIENT_EMAIL"].'" required><br>';
								echo '<h3>Mailing List</h3><select name="mailinglist">'.mailingListFn($client["CLIENT_MAILINGLIST"]).'</select>';
				        		?>
					            <div class="submitButtons">
									<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
					            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
					            </div>
				            </form>
		            <?php	
		            break;			
		            case "EditConfirm":
	            		$query = "UPDATE CLIENT SET CLIENT_GIVENNAME=:gn, CLIENT_FAMILYNAME=:fn, CLIENT_ADDRESS=:addy, CLIENT_PHONE=:ph, CLIENT_MOBILE=:mob, CLIENT_EMAIL=:em, CLIENT_MAILINGLIST=:mlst WHERE CLIENT_ID=".$_POST["clientid"];
		                $stmt = oci_parse($conn, $query);
						$gn = strtoupper($_POST["givenname"]);
						$fn = strtoupper($_POST["familyname"]);
						$addy = strtoupper($_POST["address"]);
						$ph = $_POST["phone"];
						$mob = $_POST["mobile"];
						$em = strtoupper($_POST["email"]);
						$mlst = $_POST["mailinglist"];
		                $stmt = oci_parse($conn,$query);
						oci_bind_by_name($stmt, ":gn", $gn);
						oci_bind_by_name($stmt, ":fn", $fn);
						oci_bind_by_name($stmt, ":addy", $addy);
						oci_bind_by_name($stmt, ":ph", $ph);
						oci_bind_by_name($stmt, ":mob", $mob);
						oci_bind_by_name($stmt, ":em", $em);
						oci_bind_by_name($stmt, ":mlst", $mlst);
		                if (@oci_execute($stmt)) {
		                    echo "<h2>The following client record has been successfully updated</h2></br>";
		                    echo "<h3>Client name:</h3>".$_POST["givenname"];
		                    echo "</br>";
		                    echo "<h3>Client ID:</h3>".$_POST["clientid"];
		                } else {
		                    echo "<h2 class='error'>Error updating make record</h2>";
		                }
		                echo "<input class='btn btn-lg btn-primary submitButtons' type='button' value='Return to List' OnClick='window.location=\"clients.php\"'>";
	                break;
		            	break;
		            	case "Delete":
		            ?>
			            	<h2>The record you are deleting:</h2>
			            	<form method="post" action="clients.php?Action=DeleteConfirm">

			                	<?php
			                		$query = "SELECT * FROM CLIENT WHERE CLIENT_ID=".$_GET["Client_ID"];
			                		$stmt = oci_parse($conn,$query);
			                		if(@oci_execute($stmt)){
				                		$row = oci_fetch_array($stmt);
				                		echo '<input style="display:none;" type="text" name="clientid" value="'.$_GET["Client_ID"].'">';
				                	} else {
				                		header("error.php?Reason=BackendError");
				                	}
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
							/* drop constraints */
		            		$query = "DELETE FROM CLIENT WHERE CLIENT_ID=".$_POST["clientid"];
							$stmt = oci_parse($conn,$query);
							if (@oci_execute($stmt)) {
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
						
						case "EmailSuccess":
							echo '<h2>Email sent</h2><br />';
							echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
							break;
						
						case "EmailFail":
		            		echo '<h2 class="error">Email unsuccessful</h2></br>';
		            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="clients.php">';
		            		break;
							
						case "CreatePDF":
							//header("location: clients.php");		
							//echo '<p>click</p>';
 								define('FPDF_FONTPATH', 'phputils/FPDF/font/');
								require ("phputils/FPDF/fpdf.php");
								class XFPDF extends FPDF {
									function ftable($header, $data) {
										$this -> SetFillColor(255, 0, 0);
										$this -> SetTextColor(255, 255, 255);
										$this -> SetDrawColor(128, 0, 0);
										$this -> SetLineWidth(.3);
										$this -> SetFont('', 'B');
										$w = array(25, 35, 35, 55, 25);

										for ($i = 0; $i < sizeof($header); $i++) {
											$this -> Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
										}
										$this -> Ln();
										$this -> SetFillColor(224, 235, 255);
										$this -> SetTextColor(0, 0, 0);
										$this -> SetFont('');
										$fill = 0;

										foreach ($data as $row) {
											$this -> Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
											$this -> Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
											$this -> Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
											$this -> Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
											$this -> Cell($w[4], 6, $row[4], 'LR', 0, 'L', $fill);
											$this -> Ln();
											$fill = !$fill;
										}
										$this -> Cell(array_sum($w), 0, '', 'T');
									}
								}
								$query = "SELECT * FROM CLIENT ORDER BY CLIENT_GIVENNAME";
								$stmt = oci_parse($conn, $query);
								
							/*
							$pdf = new FPDF();
							$pdf->Open();
							$pdf->AddPage();
							$pdf->SetFont('Arial', 'B' , 16);
							$pdf->Cell(40,10,'First Cell - no border',0,1);
							$pdf->Cell(100,10,'Second Cell - border/centred',1,1,'C');
							$pdf->Ln();
							$pdf->Cell(100,10,'Third Cell - top/bottom border','T,B',1);
							$pdf->Ln();
							$pdf->SetFillColor(255,0,0);
							$pdf->Cell(100,10,'Fourth Cell - border/filled',1,1,'C',1);
							$pdf->Output("PDFs/PDFFile1.pdf");
							*/
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
				<button class="edit btn btn-lg btn-primary" onClick="createPdf();">Create Clients PDF</button>
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
 	        	<form method="post" action="clients.php?Action=Add">
					<h3>Given Name:</h3><input type="text" name="givenname" required><br>
					<h3>Surname:</h3><input type="text" name="familyname" required><br>
					<h3>Address:</h3><input type="text" name="address" required><br>
					<h3>Phone:</h3><input type="text" name="phone" pattern="[0-9]*" required><br>
					<h3>Mobile:</h3><input type="text" name="mobile" pattern="[0-9]*" required><br>
					<h3>Email:</h3><input type="email" name="email">
					<h3>Mailing List</h3><select name="mailinglist">
						<option>Y</option>
						<option>N</option>
					</select>
		            <div class="submitButtons">
						<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
		            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
		            </div>
	            </form>
		    <?php
		    	} else {
		                $query = "INSERT INTO CLIENT (CLIENT_ID, CLIENT_GIVENNAME, CLIENT_FAMILYNAME, CLIENT_ADDRESS, CLIENT_PHONE, CLIENT_MOBILE, CLIENT_EMAIL, CLIENT_MAILINGLIST) VALUES(SEQ_CLIENT_ID.NEXTVAL, :gn, :fn, :addy, :ph, :mob, :em, :ml)";
		                //$query = "INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, " . $test . ", 'TEST', 'TEST', 'TEST', 'TEST', 'TEST', 'Y')";
						$stmt = oci_parse($conn, $query);
						$gn = strtoupper($_POST["givenname"]);
						$fn = strtoupper($_POST["familyname"]);
						$addy = strtoupper($_POST["address"]);
						$ph = $_POST["phone"];
						$mob = $_POST["mobile"];
						$em = strtoupper($_POST["email"]);
						$ml = $_POST["mailinglist"];
					
						oci_bind_by_name($stmt, ":gn", $gn);
						oci_bind_by_name($stmt, ":fn", $fn);
						oci_bind_by_name($stmt, ":addy", $addy);
						oci_bind_by_name($stmt, ":ph", $ph);
						oci_bind_by_name($stmt, ":mob", $mob);
						oci_bind_by_name($stmt, ":em", $em);
						oci_bind_by_name($stmt, ":ml", $ml);
						
		                if(@oci_execute($stmt)) {
		                	header("location: clients.php?Action=AddSuccess");
		                } else {
		                	header("location: clients.php?Action=AddFail");
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
						?>
						<div class="submitButtons">
							<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
		            		<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
		            	</div>
		            	<?php
						echo '</form>';
					} else {
                        $from = "From: Cyril's Classic Cars <cyril.crook@monash.edu.au>";
						$to = $_POST["to"];
						$msg = $_POST["message"];
						$subject = $_POST["subject"];
						if(mail($to, $subject, $msg, $from)) {
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
			function createPdf() {
				window.location.href = "clients.php?Action=CreatePDF";
			}
		</script>

	</body>

</html> 



