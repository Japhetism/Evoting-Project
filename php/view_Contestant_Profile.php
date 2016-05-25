<?php
include('session.php');
include_once("connection.php");
include_once("database.php");
$date_diff = '';

$contestant_user_id = $election_id_here=$joined="";
$key=$_GET['key'];
$contestant_user_id = substr($key,9,strlen($key)-17);

$election_id_here= $_SESSION["election_id_view"];

$sql1 =$connection1->prepare("SELECT contestant_id, picture_name, citation_name, post_id, nickname, election_id FROM contestants WHERE user_id='$contestant_user_id' AND election_id='$election_id_here'");
$sql1->execute();
$result1= $sql1->setFetchMode(PDO::FETCH_ASSOC);
$result1 = $sql1->fetchAll();

$joined=joined_id(user_id($myemail),$election_id_here);

if(empty($result1)&& strlen($_SESSION["election_id"])!=1 ){
    header("Location:postnews.php?key=".$_SESSION["election_id"]);
}elseif(empty($result1)&& strlen($_SESSION["election_id"])==1){
    header("Location:election_detailsNews.php?key=".$_SESSION["election_key"]);
}

//Declaring images and citation directory
$images_dir = "../images/contestants/";
$citation_dir ="../contestant_citation/";

//Declaring variables
$contestant_fullname=$contestant_election_name="";
$contestant_id= $contestant_nickname = $contestant_email =$contestant_phoneno=$contestant_post=$contestant_picture =
$contestant_post_id =$contestant_citation ="";
$manifestos = array();

$sql=$connection1->prepare("SELECT fname, lname, email, phone FROM users WHERE user_id='$contestant_user_id'");
$sql->execute();
$result= $sql->setFetchMode(PDO::FETCH_ASSOC);
$result = $sql->fetchAll();



if(!empty($result)){
    $contestant_fullname= strtoupper($result[0]["fname"]). " ". $result[0]["lname"];
    $contestant_phoneno= $result[0]["phone"];
    $contestant_nickname = $result1[0]["nickname"];
    $contestant_picture = $images_dir.$result1[0]["picture_name"];
    $contestant_post_id = $result1[0]["post_id"];
    $contestant_id= $result1[0]["contestant_id"];
    $contestant_citation =  $result1[0]["citation_name"];
    $contestant_email = $result[0]["email"];
    $contestant_election_id = $result1[0]["election_id"];


    $sql2 = $connection1->prepare("SELECT * FROM manifesto WHERE contestant_id='$contestant_id'");
    $sql2->execute();
    $result2 = $sql2->setFetchMode(PDO::FETCH_ASSOC);
    $result2 = $sql2->fetchAll();
    for ($j = 0; $j < count($result2); $j++) {
        $manifestos[$j]= $result2[$j]['manifesto'];
    }

    $sql3 = $connection1->prepare("SELECT post FROM posts WHERE post_id='$contestant_post_id'");
    $sql3->execute();
    $result3 = $sql3->setFetchMode(PDO::FETCH_ASSOC);
    $result3 = $sql3->fetchAll();
    $contestant_post=$result3[0]["post"];

    $sql4 = $connection1->prepare("SELECT election_name FROM election WHERE election_id='$election_id_here'");
    $sql4->execute();
    $result4 = $sql4->setFetchMode(PDO::FETCH_ASSOC);
    $result4 = $sql4->fetchAll();
    $contestant_election_name=$result4[0]["election_name"];

}else{

}



?>