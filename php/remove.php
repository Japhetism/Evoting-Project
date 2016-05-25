<?php
require_once'connection.php';
$user_id = $_POST["user"];
$election_id = $_POST["election"];
$datediff = $_POST["datediff"];
$status = $_POST["status"];

//check if the election has not started
if($datediff > 0) {
	if($status == 0) {
		//check if actually a true voter
		$voter = $connection1->query("SELECT joined_id FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");

		if(!empty($voter)) {
			//delete from database
			$delete = $connection1->query("DELETE FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");
			if($delete->rowCount() == 1) {
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