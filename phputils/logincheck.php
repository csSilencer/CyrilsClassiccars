<?php 

$next = urlencode($_SERVER['QUERY_STRING']);

if (!empty($_SESSION['auth'])) {
	if($_SESSION['auth'] == FALSE) {
		header("location: login.php?next=". $_SERVER['PHP_SELF'] . '?' . $next);
	} else {
		//do nothing
	}
	
} else {
	//session not even set, redirect
	header("location: login.php?next=". $_SERVER['PHP_SELF'] . '?' . $next);
}

?>