<?php
 //create MDS constants
 define("MONASH_DIR", "ldap.monash.edu.au");
 define("MONASH_FILTER","o=Monash University, c=au");
 session_start(); 
 ob_start();
?>
<html>
<head>
 <title>LDAP Example</title>
</head>
<body>
	<?php
	 $form = '';
	 if (empty($_POST["uname"]))
	 {
	 	$form = "<form method='post' action='login.php'>";

	 	if (empty($_SESSION['error'])) {
	 		//donothing
	 	} else {
	 		echo "<center style='color: red;'><p>".$_SESSION['error']."<p></center>";
	 	}
	 	if (empty($_GET["next"])) {
	 		//do nothing
	 	} else {
	 		$form = "<form method='post' action='" .$_GET["next"]."'>";
	 	}
	?>

		 <?php echo $form ?>
		 <center>Please log in using your Authcate Details
		 </center><p />
		 <table border="0" align="center" cellspacing="5">
		 <tr>
		 <td>Authcate Username</td>
		 <td>Authcate Password</td>
		 </tr>
		 <tr>
		 <td><input type="text" name="uname"
		 size="15"></td>
		 <td><input type="password" name="pword"
		 size="15"></td>
		 </tr>
		 </table><p />
		 <center>
		 <input type="submit" value="Log in">
		 <input type="reset" value="Reset">
		 </center>
	<?php
	 }
	 else
	 {
		 $LDAPconn=@ldap_connect(MONASH_DIR);
		 if($LDAPconn)
		 {
			 $LDAPsearch=@ldap_search($LDAPconn,MONASH_FILTER,
			 "uid=".$_POST["uname"]);
			 if($LDAPsearch)
			 {
				 $LDAPinfo = @ldap_first_entry($LDAPconn,$LDAPsearch);
				 if($LDAPinfo)
				 {
					 $LDAPresult= @ldap_bind($LDAPconn, ldap_get_dn($LDAPconn, $LDAPinfo),
					 $_POST["pword"]);
					 $_SESSION['error'] = null;
				 }
			 	else
				{
					$_SESSION['error'] = "Username or Password is invalid";
			 		$LDAPresult=0;
			 	}
			 } 
			 else
			 {
			 	$_SESSION['error'] = "Unable to connect to Monash auth service";
			 	$LDAPresult=0;
			 }
		 }
		 else
		 {
		 	$_SESSION['error'] = "Unable to connect to Monash auth service";
		 	$LDAPresult=0;
		 }

		 if($LDAPresult)
		 {
		 	$_SESSION['auth'] = TRUE;
		 	header("location: index.php");

		 }
		 else
		 {
		 	$_SESSION['auth'] = FALSE; //probably dont need this
			header("location: login.php");
		 }
	 }
	?>
</body>
</html> 