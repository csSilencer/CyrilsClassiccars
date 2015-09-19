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
			.code {
				border-top: 1px solid black;
				width:100%;
			}
			.tablebuttons {
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
			h3 {
				display: inline-block;
			}
			.error {
				color: red;
				font-weight: bold;
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
        	function fSelect ($value1, $value2) {
				$strSelect = "";
				if($value1 == $value2) {
					$strSelect = " SELECTED";
				}
				return $strSelect;
			}

			function getMakeByName ($makename) {
        		$query = "SELECT * FROM MAKE WHERE MAKE_NAME='".$makename."'";
        		$stmt = oci_parse($conn,$query);
				oci_execute($stmt);
				return oci_fetch_array($stmt);
			}

			$query="SELECT c.MODEL_ID, c.MODEL_NAME, m.MAKE_ID, m.MAKE_NAME  FROM CMODEL c, MAKE m
					WHERE c.MAKE_ID = m.MAKE_ID";
			$stmt = oci_parse($conn, $query);
			if(!oci_execute($stmt)) {
				echo "<center style='color: red;'><h1>Failed to connect to the database<h1></center>";
				echo "<center style='color: red;'><h2>Try refreshing<h2></center>";
			}
		?>

		<div id="tabs">
		  <ul>
		    <li><a href="#tabs-1">Existing Models</a></li>
		    <li><a href="#tabs-2">Add new Model</a></li>
		  </ul>
		  <div id="tabs-1">

		  	<?php 
		  		if(isset($_GET["Action"])) {
		  			switch($_GET["Action"]){
		  				case "Edit":
		  	?>

		  	<h2>The record you are modifying:</h2>
            <form method="post" action="models.php?Action=EditConfirm">
            	<?php
            	$query = "SELECT * FROM CMODEL WHERE MODEL_ID =".$_GET["Model_ID"];
				$stmt = oci_parse($conn, $query);
				oci_execute($stmt);
				$model = oci_fetch_array($stmt);
				$query = "SELECT * FROM MAKE";
				$stmt = oci_parse($conn, $query);
				oci_execute($stmt);
				?>
            	<h3>Make:</h3><span><?php echo $_GET["Make_Name"]?></span></br>
            	<h3>ID#:</h3><span><?php echo $_GET["Model_ID"]?></span></br>
            	<h3>Edit Make:</h3>
                	<?php
                		echo "<input style='display:none' name='modelid' value='".$_GET["Model_ID"]."'>";
                		echo "<select name='makename'>";
                		while($makes = oci_fetch_array($stmt)) {
							echo '<option value="'.$makes["MAKE_NAME"].'"' .fSelect($model["MAKE_ID"],$makes["MAKE_ID"]). '>';
							echo $makes["MAKE_NAME"];
							echo '</option>';
						}
						echo "</select>";
                	?>
            	</select>
            	<h3>Edit Model:</h3> <?php echo "<input type='text' name='modelname' value='" .$model["MODEL_NAME"]. "'>" ?>
            	<div class="submitbuttons">
            		<input class="btn btn-lg btn-primary" type="submit" value="Submit">
            		<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='models.php'">
            	</div>
            </form>
            <?php 
            	break;
            ?>
            <?php 
            	case "EditConfirm":
            		$make = getMakeByName($_POST["makename"]);
            		$query = "UPDATE CMODEL set MODEL_NAME='".$_POST["modelname"]."', MAKE_ID='".$make["MAKE_ID"]."' WHERE MODEL_ID='".$_POST["modelid"]."'";
	                $stmt = oci_parse($conn,$query);
	                if (oci_execute($stmt)) {
	                    echo "<h2>The following make record has been successfully updated</h2></br>";
	                    echo "<h3>Make name:</h3>".$_POST["makename"];
	                    echo "</br>";
	                    echo "<h3>Model ID:</h3>".$_POST["modelid"];
	                    echo "</br>";
	                    echo "<h3>Model Name:</h3>".$_POST["modelname"];
	                } else {
	                    echo "<h2 class='error'>Error updating make record</h2>";
	                }
	                echo "<input class='btn btn-lg btn-primary submitButtons' type='button' value='Return to List' OnClick='window.location=\"models.php\"'>";
	                break;
            ?>
            <?php 
            	case "Delete":
            ?>
            <h2>The record you are deleting:</h2>
        	<form method="post" action="makes.php?Action=DeleteConfirm">
        		<?php 
        			$make = getMakeByName($_GET["Make_Name"]);
        			$query = "SELECT * FROM CMODEL WHERE MODEL_ID =".$_GET["Model_ID"];
            		$stmt = oci_parse($conn,$query);
					oci_execute($stmt);
            		$model = oci_fetch_array($stmt);
        		?>
        		<h3>Make:</h3><span><?php echo $make["MAKE_NAME"]?></span></br>
            	<h3>Model Name:</h3><span><?php echo $_model["MODEL_NAME"]?></span><br/>
            	<h3>ID#:</h3><span><?php echo $_GET["Make_ID"]?></span>
            	<?php 
            		echo '<input style="display:none;" type="text" name="modelid" value="'.$_GET["Model_ID"].'">'
            	?>
            	<div class="submitbuttons">
            		<input class="btn btn-lg btn-primary" type="submit" value="Delete">
            		<input class="btn btn-lg btn-danger" type="button" value="Cancel" onClick="window.location.href='makes.php'">
            	</div>
            </form>
            <?php 
            	break;
            	case "DeleteConfirm":
            		$query = "DELETE FROM CMODEL WHERE MODEL_ID=".$_POST["modelid"];
					$stmt = oci_parse($conn,$query);
					if (oci_execute($stmt)) {
						echo '<h2>Record Deleted</h2>';
						echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="makes.php">';
					}
					else {
						echo '<h2 class="error">Deletion Failed</h2>';	
						echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="makes.php">';
					}
					break;
            	case "AddSuccess":
            		echo '<h2>Record Added successfully</h2></br>';
            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="makes.php">';
            		break;
            	case "AddFail":
            		echo '<h2 class="error">Unable to add record</h2></br>';
            		echo '<input class="btn btn-lg btn-primary" type="button" value="Return to list" onClick=window.location="makes.php">';
            		break;
            ?>
            <?php 
            	default:
            		header("location: makes.php");
            		break;
            	}
            }
            ?>
            <?php if(!isset($_GET["Action"])) 
            {
            ?>
		  	<table id="models" class="display" cellspacing="0" width="100%">
		  		<thead>
		  			<th>ModelID</th>
		  			<th>Make</th>
		  			<th>Model</th>
		  		</thead>
		  		<tfoot>
		  			<th>ModelID</th>
		  			<th>Make</th>
		  			<th>Model</th>
		  		</tfoot>
		  		<tbody>
		  			<?php 
		  				while ($row = oci_fetch_array($stmt))
		  				{
		  			?>
		  			<tr>
		  				<td><?php echo $row["MODEL_ID"]?></td>
		  				<td><?php echo $row["MAKE_NAME"]?></td>
		  				<td><?php echo $row["MODEL_NAME"]?></td>
		  			</tr>
		  			<?php 
		  			}
		  			?>
		  		</tbody>
		  	</table>
			<div class="tablebuttons">
				<button class="edit btn btn-lg btn-primary" onClick="editModel();">Edit</button>
				<button class="delete btn btn-lg btn-danger" onClick="deleteModel();">Delete</button>
			</div>
			<?php 
			}
			?>
		</div>
	    <div id="tabs-2">
			<h2>Insert a new model</h2>
	        <?php 
	        	if (!isset($_GET["Action"]) || $_GET['Action'] !="Add")
	        	{
	        ?>
        	<form method="post" action="models.php?Action=Add">
        	<h3>Makes:</h3>
        	<?php 
        		$query = "SELECT * FROM MAKE";
        		$stmt = oci_parse($conn,$query);
				oci_execute($stmt);
        		echo "<select name='makename'>";
        		while($makes = oci_fetch_array($stmt)) {
					echo '<option value="'.$makes["MAKE_NAME"].'">';
					echo $makes["MAKE_NAME"];
					echo '</option>';
				}
				echo "</select>";
        	?>
            <h3>ModelName: </h3><input type="text" name="modelname">
            <div class="submitButtons">
				<input class="btn btn-lg btn-primary" type="Submit" Value="Submit">
            	<input class="btn btn-lg btn-info"type="Reset" Value="Clear">
            </div>
            
	        <?php 
	    		} else {
	                $mn = $_POST["modelname"];
	                $makeid = getMakeByName($_POST["makename"]);
	                $query="INSERT INTO CMODEL (MODEL_ID, MAKE_ID, MODEL_NAME) VALUES (SEQ_MODEL_ID.nextval, :makeid, :mname)";
	                $stmt = oci_parse($conn, $query);
	                oci_bind_by_name($stmt, ":mname", $mn);
	                oci_bind_by_name($stmt, ":makeid", $makeid);
	                if(oci_execute($stmt)) {
	                	header("location: models.php?Action=AddSuccess");
	                } else {
	                	header("location: models.php?Action=AddFail");
	                }
	            }
	        ?>
		</div>
	</div>

		<div class="code">
			<a href="phputils/displaysource.php?filename=models.php">
				<img src="assets/model.png">
			</a>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		    $('#models').DataTable();
		});
		$(function() {
    		$( "#tabs" ).tabs();
  		});
		$(function() {
		    $('tr').on('click', function() {
		    	$('tr').removeClass('selected');
		        $(this).addClass('selected');
		        $('.tableButtons').addClass('clickable');
		    });
		});
		function editModel() {
			var rowcol1 = $('tr.selected td:first-child');
			var rowcol2 = $('tr.selected td:nth-child(1)');
			if (rowcol1) {
				//pass model and make data to make the query later simpler
				window.location.href = "models.php?Action=Edit&Model_ID=" + rowcol1[0].innerHTML + "&Make_Name=" + rowcol2[0].innerHTML;
			}
		};
		function deleteModel() {
			var rowcol1 = $('tr.selected td:first-child');
			var rowcol2 = $('tr.selected td:last-child');
			if (rowcol1) {
				//pass model and make data to make the query later simpler
				window.location.href = "models.php?Action=Delete&Model_ID=" + rowcol1[0].innerHTML + "&Make_Name=" + rowcol2[0].innerHTML;
			}
		};
		</script>
	</body>

</html> 



