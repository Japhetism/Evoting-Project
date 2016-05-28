<?php
include ('connection.php');
include_once('database.php');
include_once('function.php');

//echo base64_decode("Ni");

$invite_query= $connection1->prepare("SELECT * FROM ignored WHERE email='t@t.t'");
$invite_query->execute();
$invite_result=$invite_query->setFetchMode(PDO::FETCH_ASSOC);
$invite_result=$invite_query->fetchAll();
//print_r();
if(attached('request',3,2)==="request"){
    print "yes";
}else{
    print "No";
}