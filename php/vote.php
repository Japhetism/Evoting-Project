<?php
include_once('../php/connection.php');
include_once('../php/session.php');
include_once('../php/database.php');
include_once('../php/function.php');

$election_id=$_SESSION['election_id_view'];

//fetching the election details
$election_name = $election_start_date = $election_end_date = $election_time_from = $election_time_to = $string_election = "";
$result_tag1 = $result_tag2 =$result_display = "";
$election_details1 = getElectionDetails($election_id);
for($j=0;$j<count($election_details1);$j++){
    $election_name = $election_details1[$j]['election_name'];
    $election_start_date = $election_details1[$j]['election_start_date'];
    $election_end_date = $election_details1[$j]['election_end_date'];
    $election_time_from = $election_details1[$j]['election_time_from'];
    $election_time_to = $election_details1[$j]['election_time_to'];
    $result_display = $election_details1[$j]['result_display'];
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
    $election_end1 = $election_end_date." ".$election_time_to;
    $election_end = strtotime($election_end1);

    $electionStartDateTemp = $election_start_date." ".$election_time_from;
    $electionStartDate = convert_date($electionStartDateTemp);


   
}
$string_election ="";
$string_election.="<div class='col-md-6'><label>Election Start Date:</label> ".dateString($election_start_date)."</div> <div class='col-md-6'><label>Start time: </label> ".timeString($election_time_from)."</div><div class='col-md-6'> <label>Election End Date: </label>".
dateString($election_end_date)."</div> <div class='col-md-6'><label>End time: </label> ".timeString($election_time_to).'</div>';






$string="";
$allPosts=getAllPosts($election_id);
//for each post,get contestant
$postCon=$display=$string_array=$string_result_array=array();
$superIndex=array();
$image_dir="../images/contestants/";
for($i=0;$i<count($allPosts);$i++){
    $postCon[$allPosts[$i]['post']]=getAllContestants($allPosts[$i]['post_id']);
    array_push($superIndex,$allPosts[$i]['post']);
}
for($japhet=0;$japhet<count($postCon);$japhet++){
    $post_name=$superIndex[$japhet];
    if(!empty($postCon[$post_name])){
        $voted = ' vote(s)';

        $string='<div class="col-xs-12 col-md-4">                                            
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            '.$post_name.'
                        </div>
                        <div class="row contestant-details active" id="contestant">
                            <div class="col-xs-12">
                            </div>
                        </div>
                        <div class="panel-body">';
        $string_result='<div class="col-xs-12 col-md-4">                                            
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            '.$post_name.'
                        </div>
                        <div class="row contestant-details active" id="contestant">
                            <div class="col-xs-12">
                            </div>
                        </div>
                        <div class="panel-body">';
        for($length=0;$length<count($postCon[$post_name]);$length++){
            $display=$postCon[$post_name][$length];
            //$display holds a contestant detail
            $image=$image_dir.$display['picture_name'];
            $post_name_value=removeSpace($post_name);
            $string.='<div class="row contestant">
                        <div class="col-xs-2">
                            <img src="'.$image.'" width="40px" height="50px" >
                        </div>
                        <div class="col-xs-8" style="text-align: center;">
                            <b>'.contestantName($display['user_id']).'</b><br> (nickname)
                        </div>
                        <div class="col-xs-2" style="padding: 0">
                            <input id="option" type="radio" name="'.$post_name_value.'" value="'.$display["contestant_id"].'">
                            <label id="option"></label>
                        </div>
                    </div>';
            $string_result.='<div class="row contestant">
                                <div class="col-xs-2">
                                    <img src="'.$image.'" width="40px" height="50px" >
                                </div>
                                <div class="col-xs-8" style="text-align: center;">
                                    <b>'.contestantName($display['user_id']).'</b><br> (nickname)
                                </div>
                                <div class="col-xs-2" style="padding:5px 5px 2px 2px;text-align:center;">
                                    <b>'.$display["number_of_votes"].'</b> vote(s)
                                </div>
                            </div>';
        }

                            
        $string.='</div></div></div>';
        $string_result.='</div></div></div>';

        array_push($string_array,$string);
        array_push($string_result_array,$string_result);
    }else{

        $string = $string_result = '<div class="col-xs-12 col-md-4">                                            
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                '.$post_name.'
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        no contestants registered for this post
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        array_push($string_array,$string);
        array_push($string_result_array,$string_result); 
    }
}
$contestant_id="";$last_id=$joined_id="";
$message=$hasvoted=$message1="";
$last_vote_id=$last_id=0;

$hasvoted=hasvoted(user_id($myemail), $election_id);
if($hasvoted==0) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < count($superIndex); $i++) {
            if (isset($_POST[removeSpace($superIndex[$i])])) {
                $contestant_id = $_POST[removeSpace($superIndex[$i])];
                $last_id = incrementContestantVote($contestant_id);
            }
        }
    }
    if ($last_id !== 0) {
        $joined_id = joined_id(user_id($myemail), $_SESSION["election_id_view"]);
        $sql = "UPDATE joined SET has_voted= 1 WHERE joined_id='$joined_id'";
        $connection1->exec($sql);
        $last_vote_id = $connection1->lastInsertId();
        $message1 = "You have have successfully cast your vote thanks for using E-voting";

        header("Location:../html/electionResult.php?key=".$message1);
    }
}elseif($hasvoted==1 && $result_display=="after" && strtotime(date("H:i:s"))<strtotime($election_time_to)){
    $message="You have already voted in this election";
}
//working on the nav bar 



?>