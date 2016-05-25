<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/29/16
 * Time: 3:22 PM
 */
session_start();
include_once("connection.php");
$user_id=$_SESSION['user_id'];
$election_id=$_SESSION['election_id'];

if(isset($_POST['join'])){
    $connection1->query("INSERT INTO joined(user_id,election_id) VALUES ('$user_id','$election_id')");
	header("Location:../html/status_accept.php");
}elseif(isset($_POST['request'])){
    $connection1->query("INSERT INTO request(user_id,election_id) VALUES ('$user_id','$election_id')");
	header("Location:../html/request_sent.php");
}
// header("Location:../html/maindashboard.php");