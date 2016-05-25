<?php
	include_once('connection.php');
	include_once('session.php');
	$id = $_POST['id'];
	$userquery = "SELECT email FROM users WHERE user_id = '$id'";
	$useremail = mysqli_query($connection2,$userquery);
	$useremail = mysqli_fetch_row($useremail)[0];
	if ($useremail == $myemail){ 
		$_SESSION['adekprofilevariable'] = $useremail;
	}else{
		$_SESSION['adekprofilevariable'] = '';
	}
?>