<?php
//Establishing connection with server
include('connection.php');
//Selecting Database
$db = mysqli_select_db($connection2,"eVoting");
session_start(); //Starting Session
//Storing Session
$user_check = $_SESSION['login_user'];
//SQL query to fetch complete 
$ses_sql = mysqli_fetch_array("SELECT email FROM users WHERE email='$user_check'", $connection2);
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['email'];
if(!isset($login_session)){
	mysqli_close($connection2); //Closing Connection
	header('Location:../html/index.php'); //Redirecting to home page
}
?>