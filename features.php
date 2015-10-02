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
		<h1>Manage Features</h1>
		<?php
		$query= "SELECT * FROM FEATURE";
			$stmt = oci_parse($conn, $query);
			if(!@oci_execute($stmt)) {
				echo "<center style='color: red;'><h1>Failed to connect to the database<h1></center>";
				echo "<center style='color: red;'><h2>Try refreshing<h2></center>";
			}
		?>
		
		<div id="tabs">
		  <ul>
		    <li><a href="#tabs-1">Existing Features</a></li>
		    <li><a href="#tabs-2">New Feature</a></li>
		  </ul>
			<div id="tabs-1">
				<?php
				if(isset($_GET["Action"])) {
					switch($_GET["Action"]){
						case "Edit":
				?>

				<h2>The record you are modifying:</h2>
                <form method="post" action="features.php?Action=EditConfirm">
                	<h3>Feature:</h3><span><?php echo $_GET["Feature_Name"]?></span></br>
                	<h3>ID#:</h3><span><?php echo $_GET["Feature_ID"]?></span></br>
                	<h3>New Feature:</h3> <?php echo "<input type='text' name='featurename' value='" .$_GET["Feature_Name"]. "'>" ?>
                	<?php echo "<input style='display:none' type='text' name='featureid' value='" .$_GET["Feature_ID"]. "'>" ?>
                	<div class="submitbuttons">
                		<input class="btn btn-lg btn-primary" type="submit" value="Submit">
                		<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='features.php'">
                	</div>
                	
                </form>
                <?php 
                	break;
                ?>
                <?php 
                	case "EditConfirm":
                		$query = "UPDATE FEATURE SET FEATURE_NAME='".$_POST["featurename"]."' WHERE FEATURE_ID='".$_POST["featureid"]."'";
		                $stmt = oci_parse($conn,$query);
		                if (oci_execute($stmt)) {
		                    echo "<h2>The following feature record has been successfully updated</h2></br>";
		                    echo "<h3>Feature name:</h3>".$_POST["featurename"];
		                    echo "</br>";
		                    echo "<h3>Feature ID:</h3>".$_POST["featureid"];
		                } else {
		                    echo "<h2 class='error'>Error updating feature record</h2>";
		                }
		                echo "<input class='btn btn-lg btn-primary submitButtons' type='button' value='Return to List' OnClick='window.location=\"features.php\"'>";
		                break;
                ?>
                <?php 
                	case "Delete":
                ?>
                	<h2>The record you are deleting:</h2>
                	<form method="post" action="features.php?Action=DeleteConfirm">
	                	<h3>Feature:</h3><span><?php echo $_GET["Feature_Name"]?></span><br/>
	                	<h3>ID#:</h3><span><?php echo $_GET["Feature_ID"]?></span>
	                	<?php 
	                		echo '<input style="display:none;" type="text" name="featureid" value="'.$_GET["Feature_ID"].'">'
	                	?>
	                	<div class="submitbuttons">
	                		<input class="btn btn-lg btn-primary" type="submit" value="Delete">
	                		<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='features.php'">
	                	</div>
	                </form>
                <?php 
                	break;
                ?>
                <?php
                	case "DeleteConfirm":
                		$query = "DELETE FROM FEATURE WHERE FEATURE_ID=".$_POST["featureid"];
						$stmt = oci_parse($conn,$query);
						if (oci_execute($stmt)) {
							echo '<h2>Record Deleted</h2>';
							echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="features.php">';
						}
						else {
							echo '<h2 class="error">Deletion Failed</h2>';	
							echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="features.php">';
						}
						break;
                	case "AddSuccess":
                		echo '<h2>Record Added successfully</h2></br>';
                		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="features.php">';
                		break;
                	case "AddFail":
                		echo '<h2 class="error">Unable to add record</h2></br>';
                		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="features.php">';
                		break;
					default:
						//clear action or just redirect back
						header("location: features.php");
				?>
			  <?php
			  	break;
			  	}
			  }
			  ?>
			  <?php if(!isset($_GET["Action"])) 
			  { 
			  ?>
			  	<h2>Edit/Delete a Feature</h2>
				<table id="features" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>FeatureID</th>
			                <th>FeatureName</th>
			            </tr>
			        </thead>
			 
			        <tfoot>
			            <tr>
							<th>FeatureID</th>
			                <th>FeatureName</th>
			            </tr>
			        </tfoot>

			        <tbody>
			        	<?php 
			        		while ($row = oci_fetch_array ($stmt)) 
			        		{
			        	?>
			        	<tr>
			        		<td><?php echo $row[0]; ?></td>
			        		<td><?php echo $row[1]; ?></td>
			        	</tr>
			        	<?php
			        	} 
			        	?>
			        </tbody>
				</table>
				<div class="tablebuttons">
					<button class="edit btn btn-lg btn-primary" onClick="editFeature();">Edit</button>
					<button class="delete btn btn-lg btn-danger" onClick="deleteFeature();">Delete</button>
				</div>
		  	</div>
		  	<?php 
		  	}
		  	?>
			<div id="tabs-2">
				<h2>Insert a new Feature</h2>
		        <?php 
		        	if (!isset($_GET["Action"]) || $_GET['Action'] !="Add")
		        	{
		        ?>
	        	<form method="post" action="features.php?Action=Add">
	            <h3>Feature Name: </h3><input type="text" name="featurename">
	            <div class="submitButtons">
					<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
	            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
	            </div>
	            
		        <?php 
		    		} else {
		                $mn = $_POST["featurename"];
		                $query="INSERT INTO FEATURE (FEATURE_ID, FEATURE_NAME) VALUES (SEQ_FEATURE_ID.nextval,:mname)";
		                $stmt = oci_parse($conn, $query);
		                oci_bind_by_name($stmt, ":mname", $mn);
		                if(oci_execute($stmt)) {
		                	header("location: features.php?Action=AddSuccess");
		                } else {
		                	header("location: features.php?Action=AddFail");
		                }
		            }
		        ?>
		    </div>
		</div>
		<div class="code">
			<a href="phputils/displaysource.php?filename=features.php" target="_blank">
				<img src="assets/feature.png">
			</a>
		</div>

	  	

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$("input").prop('required',true);
			$(document).ready(function(){
			    $('#features').DataTable();
			});
			$(function() {
	    		$( "#tabs" ).tabs();
	  		});
	  		$(document).on('click', 'tr', function () {
	  			$('tr').removeClass('selected');
		        $(this).addClass('selected');
		        $('.tableButtons').addClass('clickable');
	  		});
			function editFeature() {
				var rowcol1 = $('tr.selected td:first-child');
				var rowcol2 = $('tr.selected td:last-child');
				if (rowcol1) {
					//pass the featureid and name as its more efficient, less coupled
					window.location.href = "features.php?Action=Edit&Feature_ID=" + rowcol1[0].innerHTML + "&Feature_Name=" + rowcol2[0].innerHTML;
				}
			};
			function deleteFeature() {
				var rowcol1 = $('tr.selected td:first-child');
				var rowcol2 = $('tr.selected td:last-child');
				if (rowcol1) {
					//pass the featureid and name as its more efficient, less coupled
					window.location.href = "features.php?Action=Delete&Feature_ID=" + rowcol1[0].innerHTML + "&Feature_Name=" + rowcol2[0].innerHTML;
				}
			};
		</script>
		

	</body>

</html> 



