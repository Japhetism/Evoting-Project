<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/18/16
 * Time: 2:26 PM
 */
//open connection
include_once('session.php');
include_once('connection.php');
include_once("function.php");
include_once("database.php");
//declare variables
$created_count=$joined_count=$invites_count=$requests_count=0;
//get user_id
$user_id=user_id($myemail);
//get table for created elections
$created_displayed = "<table  id='table_2' class='table table-responsive table-striped table-bordered' cellspacing='0'>
                                You are yet to create an election.
                            </table>";
$created_adek = false;
$created_elections=$connection1->query("SELECT * FROM election WHERE user_id='$user_id'");
$created_elections->setFetchMode(PDO::FETCH_ASSOC);
$created_elections=$created_elections->fetchAll();
$created_count=count($created_elections);
if($created_count>0){
    $created_displayed="<table  id='table_2' class='table table-responsive table-striped table-bordered' cellspacing='0'>
                    <thead class='primary'>
                        <tr>
                            <th>Election Name</th>
                            <th>Start Date</th>
                            <th>Start Time</th>
                            <th>End Date</th>
                            <th>End Time</th>
                            <th>Election Pin</th>
                            <th></th>
                        </tr>
                    </thead><tbody>";
    for($i=0;$i<$created_count;$i++){
        $created_displayed.="<tr>";
        $created_displayed.="<td>".$created_elections[$i]["election_name"]."</td>
                             <td>".dateString($created_elections[$i]["election_start_date"])."</td>
                             <td>".timeString($created_elections[$i]["election_time_from"])."</td>
                             <td>".dateString($created_elections[$i]["election_end_date"])."</td>
                             <td>".timeString($created_elections[$i]["election_time_to"])."</td>
                             <td>".$created_elections[$i]["election_pin"]."</td>";
        $key=  wrap($created_elections[$i]["election_id"]);
        $created_displayed.="<td><i class='fa fa-pencil default' onclick='created($key)'></i></td>";
        $created_displayed.="</tr>";
    }
    $created_displayed.=   "</tbody></table>";
    $created_adek = true;
}

//get table for joined election
$joined_displayed='You have not joined any election.';
$joined_adek = false;
$joined_elections=$connection1->query("SELECT election_id FROM joined WHERE user_id='$user_id'");
$joined_elections->setFetchMode(PDO::FETCH_ASSOC);
$joined_elections=$joined_elections->fetchAll();
$joined_count=count($joined_elections);
if($joined_count>0){
    $joined_displayed="<table  id='table_3' class='table table-striped table-bordered' cellspacing='0'>
            <thead class='warning'>
                <tr>
                    <th>Election Name</th>
                    <th>Election Start Time</th>
                    <th>Admin.'s Email Address</th>
                    <th></th>
                </tr>
            </thead><tbody>";
    for($i=0;$i<$joined_count;$i++){
        $joined_displayed.="<tr>";
        $election=getElectionDetails($joined_elections[$i]["election_id"])[0];
        $joined_displayed.="<td>".$election["election_name"]."</td>
                            <td>".dateString($election["election_start_date"])." @ ".timeString($election["election_time_from"])."</td>
                            <td>".email($election["user_id"])."</td>";
        $key=wrap($election["election_id"]);
        $joined_displayed.="<td><a href='#' onclick='joined($key)'>View</a></td>";
        $joined_displayed.="</tr>";
    }
    $joined_displayed.="</tbody></table>";
    $joined_adek = true;
}

//get table for available invites
$invite_string="You currently have no pending invite from any administrator.";
$invites_count=0;
$invites_adek = false;
$all_invites=$connection1->query("SELECT election_id,invite_date FROM invites WHERE user_id='$user_id'");
$all_invites->setFetchMode(PDO::FETCH_ASSOC);
$all_invites=$all_invites->fetchAll();
if(count($all_invites)>0){
    //extract available invites
    $available_invites=array();
    for($i=0;$i<count($all_invites);$i++){
        $current_id=$all_invites[$i]["election_id"];
        $current_election=getElectionDetails($current_id)[0];
        if(!concluded($current_election["election_start_date"],$current_election["election_time_from"],3600)){
            //get admin email address
            $admin_email=email($current_election["user_id"]);
            //get necessary values for display
            $available_invites[$invites_count]=array(
                "election_name"=>$current_election["election_name"],
                "admin_email"  =>$admin_email,
                "invite_date"  =>$all_invites[$i]["invite_date"],
                "election_id"  =>$current_id
            );
            $invites_count++;
        }
    }
    if(count($available_invites)>0){
        //get string
        $invite_string="<table id='table_4' class='table table-striped table-bordered' cellspacing='0'>
                            <thead class='danger'>
                                <tr>
                                    <th>Election Name</th>
                                    <th>Admin Address</th>
                                    <th>Invite Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>";
        for($j=0;$j<count($available_invites);$j++){
            $stuff=$available_invites[$j]["invite_date"];
            $dateStringTimeString=dateString(explode(" ",$stuff)[0])."@".timeString(explode(" ",$stuff)[1]);
            $invite_string.="<tr>";
            $invite_string.= "<td>".$available_invites[$j]["election_name"]."</td>
                              <td>".$available_invites[$j]["admin_email"]."</td>
                              <td>".$dateStringTimeString."</td>" ;
            $invite_string.="<td><span class='button btn-default btn-sm pop2' data-bpopup='{\"content\":\"iframe\",\"contentContainer\":\".content\",\"loadUrl\":\"accept_invite.php?key=".wrap($available_invites[$j]["election_id"])."\"}'>View</span></td>";

            $invite_string.="</tr>";
        }
        $invite_string.="</tbody></table>";
        $invites_adek = true;
    }
}

//get all request
$request_displayed="You currently have no pending request.";
$all_requests=$connection1->query("SELECT election_id,request_date FROM request WHERE user_id='$user_id'");
$all_requests->setFetchMode(PDO::FETCH_ASSOC);
$all_requests=$all_requests->fetchAll();
$has_request=array();
$requests_count=0;
$requests_adek= false;
//for each request,check if the election is yet to start
if(count($all_requests)>0){
    for($i=0;$i<count($all_requests);$i++){
        $election=getElectionDetails($all_requests[$i]["election_id"])[0];
        if(!concluded($election["election_start_date"],$election["election_time_from"],0)){
            //get useful details
            $has_request[$requests_count]=array(
                "election_pin" =>$election["election_pin"],
                "admin_email"  =>email($election["user_id"]),
                "request_date" =>dateString(explode(" ",$all_requests[$i]["request_date"])[0]),
                "request_time" =>timeString(explode(" ",$all_requests[$i]["request_date"])[1])
            );
            $requests_count++;
        }
    }
    //generate display
    if(count($has_request)>0){
        $request_displayed="<table id='table_5' class='table table-striped table-bordered' cellspacing='0'>
                            <thead class='default'>
                                <tr>
                                    <th>Election Pin</th>
                                    <th>Admin Address</th>
                                    <th>Request Date</th>
                                    <th>Request Time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>";
        for($i=0;$i<count($has_request);$i++){
            $request_displayed.="<tr>";
            $request_displayed.= "<td>".$has_request[$i]["election_pin"]."</td>
                              <td>".$has_request[$i]["admin_email"]."</td>
                              <td>".$has_request[$i]["request_date"]."</td>
                              <td> ".$has_request[$i]["request_time"]."</td>
                              <td class='text-danger'>pending</td>" ;
            $request_displayed.="</tr>";
        }
        $request_displayed.="</tbody></table>";
        $requests_adek = true;
    }
}

//get all public elections
$public_elections_displayed = "<table  id='table_1' class='table table-responsive table-striped table-bordered' cellspacing='0'>
                                No public election is currently available.<tbody></tbody>
                            </table>";
$public_adek = false;
$ref="";
$all_public=$connection1->prepare("SELECT * FROM election WHERE privacy='12' OR privacy='11' ORDER BY date_created DESC");
$all_public->execute();
$all_public->setFetchMode(PDO::FETCH_ASSOC);
$public_elections=$all_public->fetchAll();
$fully_public=array();
$fully=0;
//extract all fully public elections from $public elections
for($current=0;$current<count($public_elections);$current++){
    if(substr($public_elections[$current]["privacy"],1,1)==1)#election is closed
        $lag=7200;
    else#election is open
        $lag=3600;
    $totally=publicDisplayable($user_id,$public_elections[$current]['election_id']);
    if($totally!=='partially' && !concluded($public_elections[$current]["election_start_date"],$public_elections[$current]["election_time_from"],$lag)){
        $fully_public[$fully]=$public_elections[$current];
        $fully++;
    }
}

//check if there is at least one fully public election left
if(count($fully_public)>0){
    $public_elections_displayed="<table id='table_1' class='table table-striped table-bordered' cellspacing='0'>
                                <thead class='success'>
                                    <tr>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>Start Time</th>
                                        <th>End Date</th>
                                        <th>End Time</th>
                                        <th>Pin</th>
                                        <th></th>
                                    </tr>
                                </thead><tbody>";
    $public_index=array('election_name','election_start_date','election_time_from','election_end_date','election_time_to','election_pin');
    $public_index_number=count($public_index);
    for($move=0;$move<count($fully_public);$move++){
        $public_elections_displayed.="<tr>";
        for($index=0;$index<$public_index_number;$index++){
            if(count(explode("_",$public_index[$index]))===3){
                if(explode("_",$public_index[$index])[2]==='date'){
                    $public_elections_displayed.="<td>".dateString($fully_public[$move][$public_index[$index]])."</td>";
                }elseif(explode("_",$public_index[$index])[1]==='time'){
                    $public_elections_displayed.="<td>".timeString($fully_public[$move][$public_index[$index]])."</td>";
                }
            }
            else{
                $public_elections_displayed.="<td >".$fully_public[$move][$public_index[$index]]."</td>";
            }
        }
        $key=  wrap($fully_public[$move]['election_id']);
        $public_elections_displayed.="<td><span class='button btn-default btn-sm pop2' data-bpopup='{\"content\":\"iframe\",\"contentContainer\":\".content\",\"loadUrl\":\"publicElections.php?key=".$key."\"}'>View</span></td>";

        // $public_elections_displayed.="<td><a href='#' onclick='Public($key)'>See </a></td>";
        $public_elections_displayed.="</tr>";
    }
    $public_elections_displayed.=   "</tbody></table>";
    $public_adek = true;

}


?>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Table JavaScript -->
    <script src="../js/jQuery.dataTables.js"></script>