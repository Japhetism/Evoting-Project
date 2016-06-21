<?php
include_once('session.php');
include_once('connection.php');

//fetching user's photo
$images_dir = "../images/users/";
$username = $photo_fetched2 = $photo_fetched = "";
$query = "SELECT gender, fname, lname, username, picture_name FROM users WHERE email='$myemail'";
$query = $connection1->prepare($query);
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);
$row = $query->fetchAll()[0];
$photo_fetched2 = $row['picture_name'];
$sex = $row['gender'];
$username = $row['username'];
$fullname = $row['lname'].' '.$row['fname'];
if(empty($photo_fetched2)){
    if($sex === "female"){
        $photo_fetched = "../images/female.png";
    }elseif($sex === "male"){
        $photo_fetched = "../images/male.gif";
    }else{
        $photo_fetched = "../images/voting1.jpg";
    }
}else{
    $photo_fetched = $images_dir.$photo_fetched2;
    if(!file_exists($photo_fetched) && $sex==="male"){
        $photo_fetched  = "../images/male.gif";
    }elseif(!file_exists($photo_fetched) && $sex==="female"){
        $photo_fetched = "../images/female.png";
    }
}




?>