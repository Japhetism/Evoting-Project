<?php
//get user_id and election_id
require_once("function.php");
include_once('connection.php');
include_once('database.php');
$id=$_POST["id"];
$id = (explode(" ",$id)[1]);
$sender_id = (explode("_",$id)[0]);
$election_id = (explode("_",$id)[1]);

//check if voting has not started
$election = getElectionDetails($election_id)[0];
$starting_date = $election["election_start_date"];
$starting_time = $election["election_time_from"];
if(!concluded($starting_date,$starting_time,0) && isset($_POST)){
    //get needed election details in case you need to send mail
    $admin_query = "SELECT
                          election.election_name,users.fname AS admin_fname,users.lname AS admin_lname
                FROM
                          election
                LEFT JOIN
                          users
                ON
                          election.user_id = users.user_id
                WHERE
                          election_id = $election_id";
    $admin = $connection1->prepare($admin_query);
    $admin->execute();
    $admin->setFetchMode(PDO::FETCH_ASSOC);
    $admin = $admin->fetchAll()[0];
    $election_name = $admin['election_name'];
    $sender_name = strtoupper($admin['admin_fname'])." ".$admin['admin_lname'];

    //get recipient
    $recipient = getAllMembers('users',['*'],['user_id','=',$sender_id])[0];
    $recipient_address = $recipient['email'];
    $recipient_name = strtoupper($recipient['fname'])." ".$recipient['lname'];
    $mail_subject = "Your request to join ".$election_name."has been ";

    //delete request
    $delete_request_query="DELETE FROM request WHERE user_id='$sender_id' AND election_id='$election_id'";
    if($connection1->query($delete_request_query)){
        if($_POST["action"]==="accept"){

            //check if user has not been added to the election before
            if(attached('joined',$sender_id,$election_id) != 'joined'){
                //add sender to joined
                $adding_sender_query="INSERT INTO joined(user_id,election_id) VALUES ('$sender_id','$election_id')";
                if($connection1->query($adding_sender_query)){
                    //send notification
                    $mail_subject .= "granted.";
                    $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that ".$sender_name."; the administrator of ".$election_name."
                                                has granted your request to join ".$election_name.". Therefore, you are
                                                now a valid voter in the election. <a href='http://evoting.oauife.edu.ng'>Login into your account.</a>
                                                now to view the latest about the election.<br><br> We will like to remind
                                                you that, at <a href='http://evoting.oauife.edu.ng'>OAU E-voting system</a>, it
                                                is our responsibility to provide a reliable and trustworthy one-man-one-vote
                                                online voting system for you always. Thank you.";
                    sendEmail($recipient_address,$recipient_name,$mail_subject,$mail_body);
                    echo 'user has been successfully added to election.';
                }
            }


        }elseif($_POST["action"]=="reject"){
            //send notification
            $mail_subject .= "rejected.";
            $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that ".$sender_name."; the administrator of ".$election_name."
                                                has rejected your request to join ".$election_name.". The possible cause
                                                of this might be either you are not meant to be a voter in this election
                                                or you did not meet-up to the necessary requirements, as stated by the
                                                administrator of this election, needed to be a valid voter in this election.
                                                Whatever the case may be, the administrators best understands why your
                                                request was rejected.<br><br> We will like to remind you that, at
                                                <a href='http://evoting.oauife.edu.ng'>OAU E-voting system</a>, it is our
                                                responsibility to provide a reliable and trustworthy one-man-one-vote
                                                online voting system for you always. Thank you.
                                                <a href='http://evoting.oauife.edu.ng'>Login into your account.</a>";
            sendEmail($recipient_address,$recipient_name,$mail_subject,$mail_body);

            echo 'Request successfully rejected.';
        }
    }
}else{
    echo 'Election has either started or ended.';
}