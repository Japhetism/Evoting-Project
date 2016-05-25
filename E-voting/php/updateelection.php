<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/17/16
 * Time: 3:01 PM
 */
//include('session.php');
include('../php/connection.php');
include_once('../php/session.php');
include_once('../php/function.php');
$name_of_electionErr = $start_date_of_electionErr =$new_post_Err= $end_date_of_electionErr = $time_of_election_fromErr =
$time_of_election_toErr =$message=$message2= "";
$name_of_election = $name_of_election_temp = $start_date_of_election =$start_date_of_election1 = $end_date_of_election =
$end_date_of_election1 = $time_of_election_from = $time_of_election_to = $election_pin = "";

$election_id= substr($_SESSION['election_id'],9,strlen($_SESSION['election_id'])-17);
$election_details_query= "SELECT * FROM election WHERE election_id='$election_id'";
$this_election=mysqli_fetch_assoc(mysqli_query($connection2,$election_details_query));

//get all post and there corresponding pin
$old_posts=array();
$posts_query = "SELECT post_id,post_key,post FROM posts WHERE election_id='$election_id'";
$posts= mysqli_query($connection2,$posts_query);
$post_pin=mysqli_fetch_assoc($posts);
$post_string='<div class="col-lg-3"><div id="newDem">Post</div>';
$pin_string='<div class="col-lg-3"><div id="newDem1">Pin</div>';
do{
    array_push($old_posts,ucwords($post_pin['post']));
    $post_id=$post_pin['post_id'];
    $post="post".$post_id;
    $key="key".$post_id;
    $button="button".$post_id;
    $post_string.=$post_pin['post'].'<br>';
    $pin_string.=$post_pin['post_key'].'<br>';
}while($post_pin=mysqli_fetch_assoc($posts));
$post_string.='</div>';
$pin_string.='</div>';
//get current date and current time
$now_date =convert_date(date("Y-m-d"));
$now_time = convert_date(date("H:i:s"));
//check if election has not started
if(convert_date($this_election['election_start_date'])<=$now_date-(60*60)){
    $message="Voting will start in less than an hour.Your update cannot be processed.";
}
if(convert_date($this_election['election_end_date'])<$now_date){
    $message="This election has already been concluded.No changes will thus be processed.";
}
//php code for the update details
if(isset($_POST["update"])){
    //check name was changed
    if($this_election['election_name']===$_POST["name_of_election"]){
        $name_of_election=$this_election['election_name'];
    }else{
        $name_of_election="";
        if (empty($_POST["name_of_election"])) {
            $name_of_electionErr = "Name of election is required";
        } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", try_input($_POST["name_of_election"]))) {
            $name_of_electionErr = "Only letters and white space allowed";
        } else {
            $name_of_election_temp = try_input($_POST["name_of_election"]);
            $election_namearray =array();
            $election_namearray = explode(" ", ucwords($name_of_election_temp));
            for($i=0; $i<count($election_namearray); $i++){
                if(!empty($election_namearray[$i])) {
                    $name_of_election = $name_of_election . " " . trim($election_namearray[$i]);
                }
            }
            $name_of_election = trim($name_of_election);
        }
        $sql2 = $connection1->prepare("SELECT * FROM election WHERE election_name='$name_of_election'");
        $sql2->execute();
        $result1=$sql2->setFetchMode(PDO::FETCH_ASSOC);
        $result1=$sql2->fetchAll();
        if(!empty($result1)){
            $name_of_electionErr= "Sorry this election has already been created by another person";
        }
    }

    //check if date or time was changed
    if(!empty($_POST["start_date"])||!empty($_POST["end_date"])||!empty($_POST["start_hour"])||!empty($_POST["start_minute"])||!empty($_POST["end_hour"])||!empty($_POST["end_minute"])){
        //ensure all the date and time fields were actually changed
        if(empty($_POST["start_date"])){
            $message="Election start date should not be empty!";
        }elseif(empty($_POST["end_date"])){
            $message="Election end date should not be empty!";
        }elseif(empty($_POST["start_hour"])|| empty($_POST["start_minute"])){
            $message="Election start time cannot be empty!";
        }elseif(empty($_POST["end_hour"])|| empty($_POST["end_minute"])){
            $message="Election end date cannot be empty!";
        }

        //check start date relative to today
        $start_date_of_election1 = convert_date(try_input($_POST["start_date"]));
        if ($now_date > $start_date_of_election1) {
            $start_date_of_electionErr = "Invalid start date of election, date is in the past";
        } else {
            $start_date_of_election = try_input($_POST["start_date"]);
            //check end date relative to today and then start date
            $end_date_of_election1 = convert_date(try_input($_POST["end_date"]));
            if ($now_date > $end_date_of_election1) {
                $end_date_of_electionErr = "Invalid end date of election, date is in the past";
            } elseif ($start_date_of_election1 > $end_date_of_election1) {
                $end_date_of_electionErr = "Invalid election duration, end date of election cannot be less than the start date";
            } else {
                $end_date_of_election = try_input($_POST["end_date"]);
                //check time
                $time_of_election_to_temp = $_POST["end_hour"].':'.$_POST["end_minute"].':'.'00';
                $time_of_election_from_temp = $_POST["start_hour"].':'.$_POST["start_minute"].':'.'00';
                if (convert_date($start_date_of_election) === convert_date($end_date_of_election) && convert_date($end_date_of_election) === $now_date) {
                    $time_of_election_from1 = convert_date($time_of_election_from_temp);
                    $time_of_election_to1 = convert_date($time_of_election_to_temp);
                    if ($time_of_election_from1 < $now_time) {
                        $time_of_election_fromErr = "Invalid time, election date is same, time is in the past ";
                    } else {
                        $time_of_election_from = $time_of_election_from_temp;
                        if ($time_of_election_to1 < $now_time) {
                            $time_of_election_toErr = "Invalid time, election date is same, time is in the past ";
                        } else {
                            if($time_of_election_to1< $time_of_election_from1){
                                $time_of_election_toErr = "Invalid end time of election, end time of election cannot be less than the start time";
                            }elseif($time_of_election_to1==$time_of_election_from1 || $time_of_election_to1 < ($time_of_election_from1 + (2*60*60))) {
                                $time_of_election_toErr = "At least a minimum of 2 hours election duration is required" ;
                            }else {
                                $time_of_election_to = $time_of_election_to_temp;
                            }
                        }
                    }
                }elseif (convert_date($start_date_of_election) === convert_date($end_date_of_election)){
                    $time_of_election_from1 = convert_date($time_of_election_from_temp);
                    $time_of_election_to1 = convert_date($time_of_election_to_temp);
                    $time_of_election_from = $time_of_election_from_temp;
                    if($time_of_election_to1< $time_of_election_from1){
                        $time_of_election_toErr = "Invalid end time of election, end time of election cannot be less than the start time";
                    }elseif($time_of_election_to1==$time_of_election_from1 || $time_of_election_to1 < ($time_of_election_from1 + (2*60*60))) {
                        $time_of_election_toErr = "At least a minimum of 2 hours election duration is required" ;
                    }else {
                        $time_of_election_to = $time_of_election_to_temp;
                    }

                }else{
                    $time_of_election_from = $time_of_election_from_temp;
                    $time_of_election_to = $time_of_election_to_temp;
                }

            }
        }

    }
    //lets check if the admin added a new post
    if(!empty($_POST["number_of_new_posts"])){
        $number_of_new_posts=$_POST["number_of_new_posts"];
        $new_posts= array();
        for($i=1;$i<=$number_of_new_posts;$i++){
            $currentPost = 'post' . $i;
            $currentPin = 'pin' . $i;
            $new_posts[$_POST[$currentPin]] = ucwords($_POST[$currentPost]);
        }
        //check if there is no two same posts in the $new_posts.
        if(count(array_unique(array_values($new_posts)))<count(array_values($new_posts))){
            $new_post_Err="Post name should be unique for different posts<br>";
        }else{
            //check if any post in $new_post is not in $old_post
            $intersection=array_intersect($old_posts,array_values($new_posts));
            if(count($intersection)>0){
                $new_post_Err="One or more of the new posts has already been declared<br>";
            }
        }
    }
    //check if there is no error message
    if(empty($name_of_electionErr)&&empty($start_date_of_electionErr)&&empty($end_date_of_electionErr)&&empty($time_of_election_fromErr)&&empty($time_of_election_toErr)&&empty($new_post_Err)&&empty($message)){
        //update election name straight away
        $update_name_query="UPDATE election SET election_name='$name_of_election' WHERE election_id='$election_id'";
        mysqli_query($connection2,$update_name_query);
        //check if date and/or time was changed
        if(!empty($_POST["start_date"])&&!empty($_POST["end_date"])&&!empty($_POST["start_hour"])&&!empty($_POST["start_minute"])&&!empty($_POST["end_hour"])&&!empty($_POST["end_minute"])){
            $start_date_of_election=explodeDatePicker($start_date_of_election);
            $end_date_of_election=explodeDatePicker($end_date_of_election);
            $update_dateTime_query="UPDATE election
            SET election_start_date='$start_date_of_election',
                election_end_date='$end_date_of_election',
                election_time_from='$time_of_election_from',
                election_time_to='$time_of_election_to'
             WHERE election_id='$election_id'";
            mysqli_query($connection2,$update_dateTime_query);
        }
        //check if any new post was added
        if(!empty($_POST["number_of_new_posts"])){
            foreach($new_posts as $key=>$value){
                $update_post_query="INSERT INTO posts (post_key,post,election_id) VALUES ('$key','$value','$election_id')";
                mysqli_query($connection2,$update_post_query);
            }
        }
        //check if privacy level was changed
        $privacy=$_POST["privacy"];
        if(!empty($privacy)&& $privacy!==$this_election['privacy']){
            $privacy_update_query="UPDATE election SET privacy='$privacy' WHERE election_id='$election_id' ";
            mysqli_query($connection2,$privacy_update_query);
        }
        //set header to the correct page
        header("Location:postnews.php?key=".$_SESSION['election_id']);
    }

}