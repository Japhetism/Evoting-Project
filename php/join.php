<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/26/16
 * Time: 11:00 AM
 */
include_once("session.php");
include_once('connection.php');
require_once("function.php");
require_once("database.php");
if(isset($_POST["pin"]) && !empty($_POST["pin"])){
    //collect pin
    $election_pin=$_POST['pin'];
    //get the election corresponding to the pin
    $election = getAllMembers("election",["*"],["election_id","=",1])[0];
        if(count($election) != 0){
            //get openness
            $openness=substr($election["privacy"],1,1);
            //get user_id
            $user_id= user_id($myemail);
            //check if user is in anyway attached to the election
            if(concluded($election["election_end_date"],$election["election_time_to"],0)){
                echo 'This election has been concluded.';
            }elseif($openness==1 && concluded($election["election_start_date"],$election["election_time_from"],0)){
                echo 'Voting for this election has commenced.';
            }elseif($openness==1 && concluded($election["election_start_date"],$election["election_time_from"],3600)){
                echo 'Voting for this election will commence in less an hour.Therefore your request cannot be processed.';
            }elseif(attached("request",$user_id,$election["election_id"])==="request"){
                echo 'You have already sent a request to the admin of this election.Just hold on till your request is granted.Thank you.';
            }elseif(attached("election",$user_id,$election["election_id"])=="election"){
                echo 'You are the admin of this election.You cannot send a request to yourself.';
            }elseif(attached("invites",$user_id,$election["election_id"])==="invites"){
                echo 'You are already invited for this election.';
            }elseif(attached("joined",$user_id,$election["election_id"])==="joined"){
                echo '<span >You have joined this election.There is no need to send request.Thank you.</span>';
            }else{ #if open,add to joined. if closed,add to request
                $election_id=$election["election_id"];
                if($openness==1){
                    $query="INSERT INTO request (user_id,election_id) VALUES ('$user_id','$election_id')";
                    $success_message='<p style="color: #008000">Request has been passed  to the admin successfully.</p>';
                }elseif($openness==2){
                    $query="INSERT INTO joined (user_id,election_id) VALUES ('$user_id','$election_id')";
                    $success_message='<p style="color: #008000">You have successfully joined this open election.</p>';
                }
                if($connection1->query($query)){
                    echo($success_message);
                }else{
                    echo('Request processing not successful.The problem will be fixed soon.Send your request later or contact the admin to add you up.');
                }
            }
        }else{
            echo 'INVALID PIN';
        }
    }