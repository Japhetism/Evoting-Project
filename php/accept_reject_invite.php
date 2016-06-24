<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/3/16
 * Time: 11:04 AM
 */
include_once("session.php");
require_once('function.php');
include_once('connection.php');
include_once('database.php');

$election_details = $admin_details="";
//get election key
$key=$_GET['key'];
$election_id = unwrap($key);
//check if key is valid
$election_details = getElectionDetails($election_id)[0];
if(count($election_details)===0){
    header("Location:maindashboard.php");
}else{
    //check if the user truly received an invite from the election
    $query = "SELECT
            users.user_id, invites.invite_id
          FROM
            users
          LEFT JOIN
            invites
          ON
            users.user_id = invites.user_id
          WHERE
            users.email = '$myemail'
          AND
            invites.election_id = '$election_id'
          ";
    $check_invite = $connection1->prepare($query);
    $check_invite->execute();
    $check_invite->setFetchMode(PDO::FETCH_ASSOC);
    $is_invite = $check_invite->fetchAll();

    if(count($is_invite) == 0){
        header("Location:maindashboard.php");
    }else{
        //get all admin details
        $_SESSION["election_index"] = $election_details["election_id"];

        $admin_id = $election_details["user_id"];
        $admin_details = getAllMembers("users",["*"],["user_id","=",$admin_id])[0];
        $images_dir = "../images/users/";
        $election_admin_detail = "";
        $election_admin_detail .= "<div class='dem1'><img src=".$images_dir.$admin_details["picture_name"]." id='displayedPhoto'></div>";


    }

}

//check if either accept or decline button has been clicked
if(isset($_POST["accept"])||isset($_POST["decline"])){
    $election_id = $_SESSION["election_index"];
    //get user_id
    $user_id = user_id($myemail);

    //delete from invite table
    $delete_query="DELETE FROM invites WHERE user_id='$user_id' AND election_id='$election_id'";
    $connection1->query($delete_query);

    if(isset($_POST["accept"])){
        //add user to the election
        $insert_query="INSERT INTO joined(user_id,election_id) VALUES ('$user_id','$election_id')";
        $connection1->query($insert_query);
        //redirect
        header("Location:../html/status_accept.php");
    }elseif(isset($_POST["decline"])){
        //redirect
        header("Location:../html/status_decline.php");
    }
}
