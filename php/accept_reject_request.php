<?php
//get user_id and election_id
require_once("function.php");
include_once('connection.php');
$id=$_POST["id"];
$id= (explode(" ",$id)[1]);
$sender_id= (explode("_",$id)[0]);
$election_id=(explode("_",$id)[1]);

//check if voting has not started
$starting_date_query= "SELECT election_start_date,election_time_from FROM election WHERE election_id='$election_id'";
$starting_date= mysqli_fetch_row(mysqli_query($connection2,$starting_date_query))[0];
$starting_time=mysqli_fetch_row(mysqli_query($connection2,$starting_date_query))[1];
if(!concluded($starting_date,$starting_time,0) ){

    //delete request
    $delete_request_query="DELETE FROM request WHERE user_id='$sender_id' AND election_id='$election_id'";
    if(mysqli_query($connection2,$delete_request_query)){
        if($_POST["action"]==="accept"){

            //check if user has not been added to the election before
            $check_status_query="SELECT * FROM joined WHERE election_id='$election_id' AND user_id='$sender_id'";
            $check_status=mysqli_fetch_row(mysqli_query($connection2,$check_status_query));

            if(count($check_status)===0){

                //add sender to joined
                $adding_sender_query="INSERT INTO joined(user_id,election_id) VALUES ('$sender_id','$election_id')";
                if(mysqli_query($connection2,$adding_sender_query)){
                    echo 'user has been successfully added to election.';
                }
            }


        }elseif($_POST["action"]=="reject"){
            echo 'Request successfully rejected.';
        }
    }
}else{
    echo 'Election has either started or ended.';
}