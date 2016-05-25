<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/20/16
 * Time: 7:10 AM
 */
//function getAllPosts($election_id,$connection){
//    $allPosts=array();
//    $post_query="SELECT post_key,post FROM posts WHERE election_id='$election_id'";
//    $post=mysqli_query($connection,$post_query);
//    $current_post=mysqli_fetch_assoc($post);
//
//
//    do{
//        $allPosts[$current_post['post_key']]=$current_post['post'];
//
//    }while($current_post=mysqli_fetch_assoc($post));
//    return $allPosts;
//
//}
//function that gets all available posts for any election
function getAllPosts($election_id){
    global $connection1;
    $post_query=$connection1->prepare("SELECT post_id,post_key,post FROM posts WHERE election_id='$election_id'");
    $post_query->execute();
    $post_query->setFetchMode(PDO::FETCH_ASSOC);
    $allPosts=$post_query->fetchAll();
    return $allPosts;
}

//function to check attachment,returns the tablename if connected otherwise,null
function attached($tableName,$user_id,$election_id){
    global $connection1;
    $query=$connection1->prepare("SELECT election_id FROM $tableName WHERE user_id='$user_id' AND election_id='$election_id'");
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $status=$query->fetchColumn();
    if(!empty($status)){
        return $tableName;
    }else{
        return null;
    }
}

//get all contestants for a particular post using the post_id
function getAllContestants($post_id){
    global $connection1;
    $contest=$connection1->query("SELECT * FROM contestants WHERE post_id='$post_id'");
    $contest->execute();
    $contest->setFetchMode(PDO::FETCH_ASSOC);
    $contestants=$contest->fetchAll();
    return $contestants;
}

//get user names
function contestantName($user_id){
    global $connection1;
    $badmus=$connection1->prepare("SELECT fname,lname FROM users WHERE user_id='$user_id'");
    $badmus->execute();
    $badmus->setFetchMode(PDO::FETCH_ASSOC);
    $details=$badmus->fetchAll();
    return strtoupper($details[0]['fname'])." ".$details[0]['lname'];
}
//get Election details
function getElectionDetails($election_id){
    global $connection1;
    $getElectionDetails=$connection1->prepare("SELECT * FROM election WHERE election_id='$election_id'");
    $getElectionDetails->execute();
    $getElectionDetails->setFetchMode(PDO::FETCH_ASSOC);
    $election_details=$getElectionDetails->fetchAll();
    return $election_details;
}

//checking if a user has voted
function hasvoted($user_id, $election_id){
    global $connection1;
    $gabriel=$connection1->query("SELECT has_voted FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");
    $gabriel->execute();
    $gabriel->setFetchMode(PDO::FETCH_ASSOC);
    $details=$gabriel->fetchColumn();
    return $details;
}

//getting the user_id
function user_id($myemail){
    global $connection1;
    $kennedy=$connection1->prepare("SELECT user_id FROM users WHERE email='$myemail'");
    $kennedy->execute();
    $kennedy->setFetchMode(PDO::FETCH_ASSOC);
    $details=$kennedy->fetchAll();
    return $details[0]['user_id'];
}

function incrementContestantVote($contestant_id){
    global $connection1;
    $last_Id=0;
    $efe="UPDATE contestants SET number_of_votes = number_of_votes + 1 WHERE contestant_id='$contestant_id'";
    $connection1->exec($efe);
    $last_Id= $connection1->lastInsertId();
    return $last_Id;
}

function joined_id($user_id, $election_id){
    global $connection1;
    $gabriel=$connection1->query("SELECT joined_id FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");
    $gabriel->execute();
    $gabriel->setFetchMode(PDO::FETCH_ASSOC);
    $details=$gabriel->fetchColumn();
    return $details;
}