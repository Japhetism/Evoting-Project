<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 7/6/16
 * Time: 10:29 AM
 */
include_once('../php/connection.php');
include_once('../php/function.php');
include_once('../php/database.php');
date_default_timezone_set("Africa/Lagos");
//this script should execute every i don't know yet hour
$result_send = $result_ready = [];
$result_ready_num = 0;
//get all elections yet to receive result as mail
$result_send = getAllMembers("election",["*"],["result_mail_sent","=",0]);
$result_send_num = count($result_send);

//extract the ones that are ready to be mailed
for ($i = 0 ; $i < $result_send_num ; $i++)
{
    $end_date = $result_send[$i]["election_end_date"];
    $end_time = $result_send[$i]["election_time_to"];
    $election_id = $result_send[$i]["election_id"];
    $admin_id = $result_send[$i]["user_id"];

    if ( concluded($end_date,$end_time,0))
    {
        //send result to admin
        $admin_details = getAllMembers("users",["*"],["user_id","=",$admin_id])[0];
        $recipient_name = strtoupper($admin_details["fname"])." ".$admin_details["lname"];
        $recipient_address = $admin_details["email"];
        $subject = "Remember to cast your vote in ".$result_send[$i]["election_name"].".";
        $body = "Hello ".$admin_details["username"].".<br>";
        //sent the mail

        //check if there exists at least a voter in the election
        $has_voter = getAllMembers("joined",["*"],["election_id","=",$election_id]);
        if ( count($has_voter) > 0)
        {
            //get the election into one place
            $result_ready[$result_ready_num] = $result_send[$i];
            $result_ready_num++;
        }else
        {
            //set result_mail_sent to 1
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
    }
}

//lets send the result to voters
for ($k = 0 ; $k < $result_ready_num ; $k++)
{
    $election_id = $result_ready[$k]["election_id"];
    $subject = "Remember to cast your vote in ".$result_ready[$k]["election_name"].".";

    //get the voters
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

    for ($j = 0 ; $j < count($voters) ; $j++)
    {
        $recipient_name = strtoupper($voters[$j]["fname"])." ".$voters[$j]["lname"];
        $recipient_address = $voters[$j]["email"];
        $body = "Hello ".$voters[$j]["username"].".<br>";
        //send the mail
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
//get the voters then send