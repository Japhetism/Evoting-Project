<?php
$myemail = "";
session_start();
	if(!isset($_SESSION['login_user'])){
		header("Location:index.php");
	}else{
        date_default_timezone_set("Africa/Lagos");
		$myemail = $_SESSION['login_user'];
}
?>