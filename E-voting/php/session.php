<?php
$myemail = "";
session_start();
	if(!isset($_SESSION['login_user'])){
		header("Location:index.php");
	}else{
		$myemail = $_SESSION['login_user'];
}
?>