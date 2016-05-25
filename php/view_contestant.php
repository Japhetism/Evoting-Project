<?php
include_once("connection.php");
include_once("database.php");
//session_start();
$election_id =$result1 ="";
include_once('session.php');
    if(isset($_GET["key"])) {
        $key=$_GET['key'];
        $election_id = substr($key,9,strlen($key)-17);
        $_SESSION["election_id_view"] = $election_id;

    }
    if(empty($_SESSION["election_id_view"])){
        header("Location:maindashboard.php");
    }

        $election_id_here = $_SESSION["election_id_view"];

        $sql1 = $connection1->prepare("SELECT * FROM contestants WHERE election_id ='$election_id_here'");
        $sql1->execute();
        $result1 = $sql1->setFetchMode(PDO::FETCH_ASSOC);
        $result1 = $sql1->fetchAll();

        $images_dir = "../images/contestants/";

        $contestants_id = $picture_names =$contestants_user_ids=array();
        $contestants_post_id= array();

        if (!empty($result1)) {
            for($i=0;$i<count($result1);$i++){
                $contestants_id[$i]=$result1[$i]["contestant_id"];
                $picture_names[$i]= $images_dir . $result1[$i]["picture_name"];
                $contestants_user_ids[$i] = $result1[$i]["user_id"];
                $contestants_post_id[$i]= $result1[$i]["post_id"];
            }
        } else {
            echo "";
        }

$contestant_list="";
$allPosts=getAllPosts($election_id_here);
//for each post,get contestant
$postCon=$contestants_array=$string_result_array=array();
$superIndex=array();
$image_dir="../images/contestants/";
for($i=0;$i<count($allPosts);$i++){
    $postCon[$allPosts[$i]['post']]=getAllContestants($allPosts[$i]['post_id']);
    array_push($superIndex,$allPosts[$i]['post']);
}
//Store the contestants pictures in contestant_list array
for($japhet=0;$japhet<count($postCon);$japhet++){
    $post_name=$superIndex[$japhet];
    if(!empty($postCon[$post_name])){

        for($length=0;$length<count($postCon[$post_name]);$length++){
            $display=$postCon[$post_name][$length];
            //$display holds a contestant detail
            $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$display['user_id'].rand(10000,99999).rand(100,999);
            $image=$image_dir.$display['picture_name'];

            $contestant_list="<div class='col-md-4' >".
            "<div class='img'>".
                "<img src=".$image." width=100% height=200px alt=".contestantName($display['user_id']).">";

            $contestant_list.="<div class='desc'><b style='text-align:center;'>".contestantName($display['user_id'])."</b><br><small> ".$post_name."</small></div>"."<div onclick='contestants($key)' class='view-profile'><button  onclick='contestants($key)' class='btn btn-default'>View Profile</button></div>";
            $contestant_list.="</div></div>";
            array_push($contestants_array,$contestant_list);

        }


    }else{
        //no contestant for the post post_name
    }
}



?>