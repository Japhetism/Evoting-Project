<?php
require_once'function.php';
require_once'connection.php';
require_once'database.php';
$user_id = $_POST["user"];
$election_id = $_POST["election"];
$datediff = $_POST["datediff"];
$status = $_POST["status"];

//check if the election has not started
if($datediff > 0) {
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
    $recipient = getAllMembers('users',['*'],['user_id','=',$user_id])[0];
    $recipient_address = $recipient['email'];
    $recipient_name = strtoupper($recipient['fname'])." ".$recipient['lname'];

	if($status == 0) {
		//check if actually a true voter
		$voter = $connection1->query("SELECT joined_id FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");

		if(!empty($voter)) {
			//delete from database
			$delete = $connection1->query("DELETE FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");
            if($delete->rowCount() == 1) {
                //send mail
                $mail_subject = "You are no longer a valid voter in ".$election_name;
                $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that you have been removed from ".$election_name."
                                                 by ".$sender_name." who happens to be the administrator of this election.
                                                 The possible cause of this might be either you became a voter in this election
                                                 in a wrong way or you did not meet-up to the necessary requirements, as
                                                  stated by the administrator of this election, needed to be a valid voter
                                                  in this election. Whatever the case may be, the administrators best
                                                   understands why you were removed from this election.<br><br> We will
                                                   like to remind you that, at <a href='http://evoting.oauife.edu.ng'>OAU E-voting system</a>,
                                                   it is our responsibility to provide a reliable and trustworthy one-man-one-vote
                                                   online voting system for you always. Thank you.
                                                   <a href='http://evoting.oauife.edu.ng'>Login into your account.</a>";
                sendEmail($recipient_address,$recipient_name,$mail_subject,$mail_body);

				echo "User is no more a voter";
			}
			else {
				echo 'Sorry, unable to remove this voter';
			}
		}
	}
	elseif($status==1){
		$contestant = $connection1->query("SELECT contestant_id FROM contestants WHERE user_id = '$user_id' AND election_id = '$election_id'");
		if(!empty($contestant)) {
			$contestant->setFetchMode(PDO::FETCH_ASSOC);
			$con=$contestant->fetchAll();
			$con_id=$con[0]['contestant_id'];
			$manifestoDelete=$connection1->query("DELETE FROM manifesto WHERE contestant_id='$con_id'");
			$delete = $connection1->query("DELETE FROM contestants WHERE user_id = '$user_id' AND election_id = '$election_id'");
			if($manifestoDelete && $delete->rowCount() == 1) {
                //send mail
                $mail_subject = "You are no longer a valid contestant in ".$election_name;
                $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that you have been removed from the list of
                                                 contestants in ".$election_name." This was done solely at the discretion
                                                 of ".$sender_name." who happens to be the administrator of this election.
                                                 The possible cause of this might be because you became a contestant in this election
                                                 in a wrong way, you registered for a post different from the one you were
                                                  screened for or you did not meet-up to the necessary requirements, as
                                                  stated by the administrator of this election, needed to be a valid contestant
                                                  in this election. Whatever the case may be, the administrators best
                                                   understands why you were deprived of this.<br><br> We will
                                                   like to remind you that, at <a href='http://evoting.oauife.edu.ng'>OAU E-voting system</a>,
                                                   it is our responsibility to provide a reliable and trustworthy one-man-one-vote
                                                   online voting system for you always. Thank you.
                                                   <a href='http://evoting.oauife.edu.ng'>Login into your account.</a>";
                sendEmail($recipient_address,$recipient_name,$mail_subject,$mail_body);
				echo "Voter is no longer a contestant for this election";
			}
			else {
				echo 'Sorry, unable to remove this contestant';
			}
		}
	}
}
else{
	echo 'Sorry, you cannot remove any voter or contestant at this point of the election';
}
?>