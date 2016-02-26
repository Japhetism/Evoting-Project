<?php
include('../php/connection.php');
include_once('../php/session.php');
include_once('../php/database.php');
include_once('../php/function.php');

$election_id=$_SESSION['election_id_view'];

//fetching the election details
$election_name = $election_start_date = $election_end_date = $election_time_from = $election_time_to = $string_election = "";
$election_details = getElectionDetails($election_id);
for($j=0;$j<count($election_details);$j++){
    $election_name = $election_details[$j]['election_name'];
    $election_start_date = $election_details[$j]['election_start_date'];
    $election_end_date = $election_details[$j]['election_end_date'];
    $election_time_from = $election_details[$j]['election_time_from'];
    $election_time_to = $election_details[$j]['election_time_to'];
    $election_date =strtotime($election_start_date." ".$election_time_from);
    $parts = explode('-', $election_start_date);
    $start_year = $parts[0];
    $start_month = $parts[1];
    $start_day = $parts[2];
    $part1 = explode(':', $election_time_from);
    $start_hour = $part1[0];
    $start_minute = $part1[1];
    $part2 = explode('-', $election_end_date);
    $end_year = $part2[0];
    $end_month = $part2[1];
    $end_day = $part2[2];
    $part3 = explode(':', $election_time_to);
    $end_hour = $part3[0];
    $end_minute = $part3[1];

      //getting the election duration
    $election_end = strtotime($election_end_date." ".$election_time_to);
}
$string_election ="<div><h1>".$election_name."</h1></div>";
$string_election.="<div><label>Election Start Date:</label> ".dateString($election_start_date)." <label>Time:</label> ".timeString($election_time_from)."<br><label>Election End Date:</label> &nbsp".
dateString($election_end_date)." <label>Time:</label> ".timeString($election_time_to)."<div>";




$message=$hasvoted="";
$hasvoted=hasvoted(user_id($myemail), $election_id);
if($hasvoted==1){
    $message="You have already casted your vote for this election";
    header("Location:viewcontestant.php");
}

$string="";
$allPosts=getAllPosts($election_id);
//for each post,get contestant
$postCon=$display=$string_array=array();
$superIndex=array();
$image_dir="../images/contestants/";
for($i=0;$i<count($allPosts);$i++){
    $postCon[$allPosts[$i]['post']]=getAllContestants($allPosts[$i]['post_id']);
    array_push($superIndex,$allPosts[$i]['post']);
}
for($japhet=0;$japhet<count($postCon);$japhet++){
    $post_name=$superIndex[$japhet];
    if(!empty($postCon[$post_name])){
        $string='<div class = "row"><h1>'.$post_name.'</h1>';
        for($length=0;$length<count($postCon[$post_name]);$length++){
            $display=$postCon[$post_name][$length];
            //$display holds a contestant detail
            $image=$image_dir.$display['picture_name'];
            $post_name_value=removeSpace($post_name);
            $string.="<div class = 'col-xs-6 col-sm-4'>
                        <input type='radio' name='".$post_name_value."' value='".$display["contestant_id"]."'>".
                        "<img src=".$image." width=50% height=50%><br>".contestantName($display['user_id']);

            $string.="</div>";
        }
        $string.='</div>';
        array_push($string_array,$string);
    }else{
        //no contestant for the post post_name
    }
}
$contestant_id="";$last_id=$joined_id="";
$last_vote_id=$last_id=0;
if($hasvoted==0) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for($i=0; $i<count($superIndex); $i++){
            if(isset($_POST[removeSpace($superIndex[$i])])){
                $contestant_id= $_POST[removeSpace($superIndex[$i])];
                $last_id=incrementContestantVote($contestant_id);
            }
        }
    }
    if($last_id !== 0){
        $joined_id=joined_id(user_id($myemail), $_SESSION["election_id_view"]);
        $sql="UPDATE joined SET has_voted= 1 WHERE joined_id='$joined_id'";
        $connection1->exec($sql);
        $last_vote_id= $connection1->lastInsertId();
    }
}
if($last_vote_id!==0){
    $message="You have successfully casted your vote. Thanks for using E-voting";
}

?>