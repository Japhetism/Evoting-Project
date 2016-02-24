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