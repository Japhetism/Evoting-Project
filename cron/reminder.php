<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 7/6/16
 * Time: 10:28 AM
 */
include_once('../php/connection.php');
include_once('../php/function.php');
include_once('../php/database.php');
//this script should execute at every hour
date_default_timezone_set("Africa/Lagos");
$to_remind = $remind_ready = [];
$remind_ready_num = 0;
$main_body = "We will like to remind you that, at <a href='http://evoting.oauife.edu.ng'>OAU E-voting system</a>, it
                is our responsibility to provide a reliable and trustworthy one-man-one-vote online voting system for
                you always. Thank you. <a href='http://evoting.oauife.edu.ng'>Login into your account.</a>";

//get all elections yet to receive reminder
$to_remind = getAllMembers("election",["*"],["reminder_sent","=",0]);
$to_remind_num = count($to_remind);

//extract those that will start in at least an hour time and yet to start (2 step authentication which may not be necessary)
for ($i = 0 ; $i < $to_remind_num ; $i++)
{
    $start_date = $to_remind[$i]["election_start_date"];
    $start_time = $to_remind[$i]["election_time_from"];

    if ( concluded($start_date,$start_time,3600) && !concluded($start_date,$start_time,0) )
    {
        //send reminder to the admin
        $admin_id = $to_remind[$i]["user_id"];
        $subject = "Remember to cast your vote in ".$to_remind[$i]["election_name"].".";
        $admin_details = getAllMembers("users",["*"],["user_id","=",$admin_id])[0];
        $recipient_name = strtoupper($admin_details["fname"])." ".$admin_details["lname"];
        $body = "Hello ".$admin_details["username"].".<br>
                This is to bring to your notice that the aforementioned election will commence in less than an hour from
                the time this remainder was received by you. You are being reminded of this as regards to the fact that
                you are the administrator of this election.<br><br>".$main_body;
        $recipient_address = $admin_details["email"];
        sendEmail($recipient_address,$recipient_name,$subject,$body);

        //check if there is at least a voter in the election
        $id = $to_remind[$i]["election_id"];
        $has_voter = getAllMembers("joined",["*"],["election_id","=",$id]);
        if (count($has_voter) > 0)
        {
            //get all the ready election into an array
            $remind_ready[$remind_ready_num] = $to_remind[$i];
            $remind_ready_num++;
        }else
        {
            //just set the reminder_sent to 1 and forget about the election
            $election_update_query = "UPDATE
                                        election
                                      SET
                                        remainder_sent = 1
                                      WHERE
                                         election_id = :election_id";
            $update = $connection1->prepare($election_update_query);
            $update->bindParam(':election_id',$id);
            $update->execute();
        }
    }
}

//send reminder to those joined to each of $remind_ready
for ( $j = 0 ; $j < count($remind_ready) ; $j++ )
{
    $election_id = $remind_ready[$j]["election_id"];
    $election_name = $remind_ready[$j]["election_name"];

    //get needed details of those joined to the current election
    $query = "SELECT
                users.fname,users.lname,users.username,users.email
          FROM
                joined
          LEFT JOIN
                users
          ON
                joined.user_id = users.user_id
          WHERE
                joined.election_id = :election_id";
    $voters = $connection1->prepare($query);
    $voters->bindParam(':election_id',$election_id);
    $voters->execute();
    $voters = $voters->fetchAll(PDO::FETCH_ASSOC);

    //prepare mail subject
    $subject = "Remember to cast your vote in ".$election_name.".";
    //send reminder
    for ($k = 0 ; $k < count($voters) ; $k++)
    {
        $recipient_name = strtoupper($voters[$i]["fname"])." ".$voters[$i]["lname"];
        $body = "Hello ".$voters[$i]["username"].".<br> This is to bring to your notice that the aforementioned election
                 will commence in less than an hour from the time this remainder was received by you. You are being
                 reminded of this as regards to the fact that you have successfully registered to participate in the
                 election. So, go ahead and make your vote count!!!.<br><br>".$main_body;
        $recipient_address = $voters[$i]["email"];
        sendEmail($recipient_address,$recipient_name,$subject,$body);
    }
    //set remainder_sent to 1
    $election_update_query = "UPDATE
                                election
                              SET
                                remainder_sent = 1
                              WHERE
                                election_id = :election_id";
    $update = $connection1->prepare($election_update_query);
    $update->bindParam(':election_id',$election_id);
    $update->execute();
}