<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/3/16
 * Time: 11:04 AM
 */
require_once('function.php');

session_start();

if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
    //open connection
    include_once('../php/connection.php');
    //get election key
    $key=$_GET['key'];
    $election_id = unwrap($key);
    //check if key is valid
    $election_id_check_query="SELECT * FROM election WHERE election_id='$election_id'";
    $election_id_check= mysqli_query($connection2,$election_id_check_query);
    $election_details= mysqli_fetch_row($election_id_check);
    if(count($election_details)===0){
        header("Location:maindashboard.php");
    }else{
        //check if the user truly received an invite from the election
        //get user_id from email
        $user_id_query="SELECT user_id FROM users WHERE email='$myemail'";
        $user_id =mysqli_query($connection2,$user_id_query);
        $user_id=mysqli_fetch_row($user_id);
        //check if invite exists
        $is_invite_query="SELECT * FROM invites WHERE user_id='$user_id[0]' AND election_id='$election_id'";
        $is_invite=mysqli_query($connection2,$is_invite_query);
        $is_invite= mysqli_fetch_row($is_invite);
        if(count($is_invite)===0){
            header("Location:maindashboard.php");
        }else{
            //get all admin details
            $_SESSION["election_index"]=$election_details[0];

            $admin_details_query ="SELECT * FROM users WHERE user_id='$election_details[8]'";
            $admin_details= mysqli_fetch_row(mysqli_query($connection2,$admin_details_query));
        }

    }
}else{
    header("Location:index.php");
}
//getting the user_id for a particular election
$images_dir = "../images/users/";
$election_user_id = "SELECT user_id FROM election WHERE election_id = '$election_id'";
$user_id_result = mysqli_fetch_row(mysqli_query($connection2, $election_user_id));

//querying to get the admin email
$view_user = "SELECT * FROM  users WHERE user_id = '$user_id_result[0]'";
$view_user_name = mysqli_query($connection2, $view_user);
$view_user_details = mysqli_fetch_row($view_user_name);

$election_admin_detail = "";

if($view_user_details){
    do{

        for($i=10; $i<11; $i++){
            $election_admin_detail .= "<div class='dem1'><img src=".$images_dir.$view_user_details[$i]." id='displayedPhoto'></div>";
        }

    }while($view_user_details = mysqli_fetch_row($view_user_name));
}else{
    $election_admin_details = "";
}
//check if either accept or decline button has been clicked
if(isset($_POST["accept"])||isset($_POST["decline"])){
    $election_id = $_SESSION["election_index"];
    //get user_id
    $user_id_query="SELECT user_id FROM users WHERE email='$myemail'";
    $user_id=mysqli_fetch_row(mysqli_query($connection2,$user_id_query))[0];

    //delete from invite table
    $delete_query="DELETE FROM invites WHERE user_id='$user_id' AND election_id='$election_id'";
    mysqli_query($connection2,$delete_query);

    if(isset($_POST["accept"])){
        //add user to the election
        $insert_query="INSERT INTO joined(user_id,election_id) VALUES ('$user_id','$election_id')";
        mysqli_query($connection2,$insert_query);
        //redirect
        header("Location:../html/status_accept.php");
    }elseif(isset($_POST["decline"])){
        //redirect
        header("Location:../html/status_decline.php");

    }

}
