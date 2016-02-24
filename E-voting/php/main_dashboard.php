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

//get table for created elections
$get_id = "SELECT user_id FROM users WHERE email='$myemail'";
$user_id =  mysqli_fetch_row(mysqli_query($connection2,$get_id));
$admin_query= "SELECT * FROM election WHERE user_id='$user_id[0]' ORDER BY date_created DESC";
$admin= mysqli_query($connection2,$admin_query);
$add=mysqli_fetch_row($admin);
$elections_displayed="";

if($add){
    $elections_displayed.="<table>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Pin</th>
														<th></th>
                                                    </tr>";
    do {
        $elections_displayed.="<tr >";
        for($i=1;$i<=6;$i++)
        {
            if($i=='2'||$i=='3'){
                $elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>".dateString($add[$i])."</td>";
            }elseif($i=='4'||$i=='5'){
                $elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>".timeString($add[$i])."</td>";

            }else{
                $elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>$add[$i]</td>";
            }
        }
        $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$add[0].rand(10000,99999).rand(100,999);
        $elections_displayed.="<td><a href='#' onclick='created($key)'>Edit </a></td>";
        $elections_displayed.="</tr>";

    }  while($add=mysqli_fetch_row($admin));

    $elections_displayed.=   "</table>";
}else{
    $elections_displayed.="You are yet to create an election";
}

//get table for joined elections
$joined_displayed='';
$election_id_query= "SELECT election_id FROM joined WHERE user_id='$user_id[0]' ";
$election_id=mysqli_query($connection2,$election_id_query)or print('election_id problem');
$election_id_value= mysqli_fetch_row($election_id);
if($election_id_value){
    $joined_displayed.="<table>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Date</th>
                                                            <th>Admin</th>
                                                            <th></th>
                                                        </tr>";
    do{
        $election_details_query="SELECT * FROM election WHERE election_id='$election_id_value[0]'";
        $detail= mysqli_query($connection2,$election_details_query);
        $details=mysqli_fetch_row($detail);
        $joined_displayed.="<tr>";
        $joined_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>$details[1]</td>";
        $joined_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>".dateString($details[2])."</td>";


        $get_admin_query="SELECT * FROM users WHERE user_id='$details[8]'";
        $get_admin=mysqli_query($connection2,$get_admin_query);
        $admin_details= mysqli_fetch_row($get_admin);
        $joined_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>$admin_details[4]</td>";
        $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$details[0].rand(10000,99999).rand(100,999);

        $joined_displayed.="<td><a href='#' onclick='joined($key)'>View</a></td>";
        $joined_displayed.="</tr>";
    }while($election_id_value=mysqli_fetch_row($election_id));
    $joined_displayed.="</table>";

}else{
    $joined_displayed.='You have not joined any election';
}

//get table received invites if available
$invites_displayed="";
$has_invite_query= "SELECT user_id,election_id,invite_date FROM invites WHERE user_id='$user_id[0]'";
$has_invite= mysqli_query($connection2,$has_invite_query);
$has_invites= mysqli_fetch_row($has_invite);
if(count($has_invites)!==0){
    $invites_displayed='<div class="col-md-10 col-md-offset-1 ">
						<div class="col-md-12 electheading">
							<ol class="breadcrumb">
								<li class="active">
									Pending Invites
								</li>
							</ol>
						</div>
						<div class="col-md-12 electlist">
							<div class="row">
                                <div class="col-md-10 col-md-offset-2 ">';
    $invites_displayed.="<table>
                                                    <tr>
                                                        <th>Election Name</th>
                                                        <th>Admin Address</th>
                                                        <th>Invite Date</th>
                                                        <th></th>
                                                    </tr>";
    do{
        $invites_displayed.="<tr>";
        $current_user_id=$has_invites[0];
        $current_election_id=$has_invites[1];
        $current_invite_date=$has_invites[2];

        $current_election_details_query="SELECT * FROM election WHERE election_id='$current_election_id'";
        $current_election_details = mysqli_query($connection2,$current_election_details_query);
        $current_election_details = mysqli_fetch_row($current_election_details);
        $current_election_name=$current_election_details[1];
        $current_admin_id=$current_election_details[8];
        $admin_email_query="SELECT email FROM users WHERE user_id='$current_admin_id'";
        $admin_email= mysqli_query($connection2,$admin_email_query);
        $admin_email= mysqli_fetch_row($admin_email)[0];
        $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$current_election_details[0].rand(10000,99999).rand(100,999);
        $current_invite_date=dateString(explode(" ",$current_invite_date)[0])." ".timeString(explode(" ",$current_invite_date)[1]);
        $invites_displayed.= "<td style='padding: 0 20px 5px 2px;border: none'>$current_election_name</td>
                                                  <td>$admin_email</td>
                                                  <td>$current_invite_date</td>" ;
        $invites_displayed.="<td><a href='#' onclick='invited($key)'>Check </a></td>";

        $invites_displayed.=  "</tr>";

    }while($has_invites= mysqli_fetch_row($has_invite));
    $invites_displayed.="</table>";
    $invites_displayed.=' </div>
                            </div>
						</div>
					    </div>';
}


//get table for all sent requests if available
$request_displayed="";
$has_request_query= "SELECT user_id,election_id,request_date FROM request WHERE user_id='$user_id[0]'";
$has_requests= mysqli_query($connection2,$has_request_query);
$has_request= mysqli_fetch_row($has_requests);
if(count($has_request)!==0){

    $request_displayed='<div class="col-md-10 col-md-offset-1 ">
						<div class="col-md-12 electheading">
							<ol class="breadcrumb">
								<li class="active">
									Pending Requests
								</li>
							</ol>
						</div>
						<div class="col-md-12 electlist">
							<div class="row">
                                <div class="col-md-10 col-md-offset-2 ">';
    $request_displayed.="<table>
                                                    <tr>
                                                        <th>Election Pin</th>
                                                        <th>Admin Address</th>
                                                        <th>Request Date</th>
                                                    </tr>";
    do{
        $request_displayed.="<tr>";
        $current_user_id=$has_request[0];
        $current_election_id=$has_request[1];
        $current_request_date=$has_request[2];

        $current_election_details_query="SELECT * FROM election WHERE election_id='$current_election_id'";
        $current_election_details = mysqli_query($connection2,$current_election_details_query);
        $current_election_details = mysqli_fetch_row($current_election_details);
        $current_election_pin=$current_election_details[6];
        $current_admin_id=$current_election_details[8];
        $admin_email_query="SELECT email FROM users WHERE user_id='$current_admin_id'";
        $admin_email= mysqli_query($connection2,$admin_email_query);
        $admin_email= mysqli_fetch_row($admin_email)[0];

        $request_displayed.= "<td style='padding: 0 20px 5px 2px;border: none'>$current_election_pin</td>
                                                  <td>$admin_email</td>
                                                  <td>".dateString(explode(" ",$current_request_date)[0])." ".timeString(explode(" ",$current_request_date)[1])."</td>" ;
        $request_displayed.=  "</tr>";

    }while($has_request= mysqli_fetch_row($has_requests));
    $request_displayed.="</table>";
    $request_displayed.=' </div>
                            </div>
						</div>
					    </div>';
}

//get all public elections
$public_elections_displayed="";
$all_public=$connection1->prepare("SELECT * FROM election WHERE privacy='public' ORDER BY date_created DESC");
$all_public->execute();
$all_public->setFetchMode(PDO::FETCH_ASSOC);
$public_elections=$all_public->fetchAll();
$fully_public=array();
$fully=0;
//extract all fully public elections from $public elections
for($current=0;$current<count($public_elections);$current++){
    $totally=publicDisplayable($user_id[0],$public_elections[$current]['election_id']);
    if($totally!=='partially'){
        $fully_public[$fully]=$public_elections[$current];
        $fully++;
    }
}

//check if there is at least one fully public election left
if(count($fully_public)>0){
    $public_elections_displayed.= '<div class="row elections1">'.
        '<div class="col-md-12">'.
        '<div class="col-md-12 electheading">'.
        '<ol class="breadcrumb">'.
        '<li class="active">'.
        'Public Elections
            </li>
</ol>
</div>
<div class="col-md-12 electlist">
<div class="row">
    <div class="col-md-11 col-md-offset-1 ">';
    $public_elections_displayed.="<table >
                                <tr>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>Start Time</th>
                                    <th>End Date</th>
                                    <th>End Time</th>
                                    <th>Pin</th>
                                    <th></th>
                                </tr>";
    $public_index=array('election_name','election_start_date','election_time_from','election_end_date','election_time_to','election_pin');
    $public_index_number=count($public_index);
    for($move=0;$move<count($fully_public);$move++){
        $public_elections_displayed.="<tr >";
        for($index=0;$index<$public_index_number;$index++){
            if(count(explode("_",$public_index[$index]))===3){
                if(explode("_",$public_index[$index])[2]==='date'){
                    $public_elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>".dateString($fully_public[$move][$public_index[$index]])."</td>";
                }elseif(explode("_",$public_index[$index])[1]==='time'){
                    $public_elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>".timeString($fully_public[$move][$public_index[$index]])."</td>";
                }
            }
            else{
                $public_elections_displayed.="<td style='padding: 0 20px 5px 2px;border: none'>".$fully_public[$move][$public_index[$index]]."</td>";
            }
        }
        $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$fully_public[$move]['election_id'].rand(10000,99999).rand(100,999);
        $public_elections_displayed.="<td><a href='#' onclick=''>See </a></td>";
        $public_elections_displayed.="</tr>";
    }
    $public_elections_displayed.=   "</table>";
    $public_elections_displayed.= '</div>
                                    </div>
                                </div>
                            </div>';

}else{
    $public_elections_displayed.="";
}
