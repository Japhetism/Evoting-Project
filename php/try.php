<?php
include ('connection.php');
include_once('database.php');
include_once('function.php');

//echo base64_decode("Ni");

//function subme($a, $b)
//{
//    return $a-$b;
//}
$election=getElectionDetails(1)[0];
if (concluded($election["election_end_date"], $election["election_time_to"], 0) && $election["result_mail_sent"]==0) {
    //make all variable declaration
    $all_member = $members = $participants = [];
    //all member needs to be mailed
    $all_member = getAllMembers("joined",["user_id"],["election_id","=",$election["election_id"]]);
    //add admin to member
    array_push($all_member,["user_id" => $election["user_id"]]);
    //reduce the array to a one dimensional array
    for ($head = 0; $head < count($all_member); $head++) {
        array_push($members,$all_member[$head]["user_id"]);
    }
    //shuffle array for the case when the admin is also a voter
    $participants = array_unique($members);

    print_r($participants);

//    echo("concluded");
}else {
    echo("on point");
}