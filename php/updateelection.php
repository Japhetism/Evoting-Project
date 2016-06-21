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
include_once('../php/database.php');
$name_of_electionErr = $start_date_of_electionErr =$new_post_Err= $end_date_of_electionErr = $time_of_election_fromErr =
$time_of_election_toErr =$message=$message2= $post1 = $pin1 = $status_string= "";
$name_of_election = $name_of_election_temp = $start_date_of_election =$start_date_of_election1 = $end_date_of_election =
$end_date_of_election1 = $time_of_election_from = $time_of_election_to = $election_pin = $result_display= "";
$dummy1=$dummy2=$dummy3=$dummy4="";
$election_id= unwrap($_SESSION['election_id']);
$this_election = getAllMembers("election",["*"],["election_id","=",$election_id])[0];

//get all post and there corresponding pin
$old_posts = array();
$post_pin = getAllMembers("posts",["post_id,post_key,post"],["election_id","=",$election_id]);
$post_string='<div class="" style="text-align:left"><b>Post(s)</b><br>';
$pin_string='<div class="" style="text-align:left"><b>Pin(s)</b><br>';

for ($i = 0 ; $i < count($post_pin) ; $i++)
{
    array_push($old_posts,ucwords($post_pin[$i]["post"]));
    $post_id = $post_pin[$i]["post_id"];
    $post_string .= $post_pin[$i]["post"].'<br>';
    $pin_string .= $post_pin[$i]["post_key"].'<br>';
}
$post_string.='</div>';
$pin_string.='</div>';
//get current date and current time
$now_date =convert_date(date("Y-m-d"));
$now_time = convert_date(date("H:i:s"));
//check if election has not started
if(concluded($this_election["election_start_date"],$this_election["election_time_from"],7200)){
    $message="Voting will start in less than 2hours.Your update cannot be processed.";
}if(concluded($this_election["election_start_date"],$this_election["election_time_from"],0)){
    $message="Voting has commenced.Your update cannot be processed.";
}if(concluded($this_election["election_end_date"],$this_election["election_time_to"],0)){
    $message="This election has already been concluded.No changes will thus be processed.";
}
//election status
$status=$this_election["privacy"];
$privacy=substr($status,0,1);
$openness=substr($status,1,1);
$display=$this_election["result_display"];
//get string to display status changing woreva
$status_string='<div class="row form-group" >
                    <div class="col-xs-12 col-md-12">
                    <label>Do you want your election to be visible to all users?</label> <br>
                    <input type="radio" name="privacy" value="1" required';
if($privacy==1)
    $status_string.=' checked';
$status_string.='>Yes
                 <input type="radio" name="privacy" value="2" required';
if($privacy==2)
    $status_string.=' checked';
$status_string.='>No<br><br>
                 <label>Do you want to authenticate your voters before joining this election?</label><br>
                 <input type="radio" name="openness" value="1" required';
if($openness==1)
    $status_string.=' checked';
$status_string.='>Yes
                 <input type="radio" name="openness" value="2" required';
if($openness==2)
    $status_string.=' checked';
$status_string.='>No';
$status_string.=   '</div>
                </div>
                <div class="form-group">
                    <div >
                       <label >When do you want election result to be display?</label><br>
                    <input type="radio" name="result_display" value="after" required';
if($display=='after')
    $status_string.=' checked';
$status_string.='>After Election
                       <input type="radio" name="result_display" value="during" required';
if($display=='during')
    $status_string.=' checked';
$status_string.='>During Election
                    </div>
                </div><br>';
$dummy1=dateString($this_election["election_start_date"]);
$dummy2=dateString($this_election["election_end_date"]);
$dummy3=timeString($this_election["election_time_from"]);
$dummy4=timeString($this_election["election_time_to"]);
//php code for the update details
if(isset($_POST["update"])){
    //retain new inputs for date and time
    $dummy1=$_POST["start_date"];
    $dummy2=$_POST["end_date"];
    $dummy3=$_POST["start_time"];
    $dummy4=$_POST["end_time"];
    //check name was changed
    if($this_election['election_name']===$_POST["name_of_election"]){
        $name_of_election=$this_election['election_name'];
    }else{
        $name_of_election="";
        if (empty($_POST["name_of_election"])) {
            $name_of_electionErr = "Name of election is required";
        } else if (!preg_match("/^[\w \/]*$/", try_input($_POST["name_of_election"]))) {
            $name_of_electionErr = "Only letters,backslash,underscore and white space allowed.";
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
            $name_of_electionErr= "Election name already exists.";
        }
    }

    //check if date or time was changed
    if(!empty($_POST["start_date"])||!empty($_POST["end_date"])||!empty($_POST["start_time"])||!empty($_POST["end_time"])){
        //ensure all the date and time fields were actually changed
        if(empty($_POST["start_date"])){
            $message="Election start date should not be empty!";
        }elseif(empty($_POST["end_date"])){
            $message="Election end date should not be empty!";
        }elseif(empty($_POST["start_time"])){
            $message="Election start time should not be empty!";
        }elseif(empty($_POST["end_time"])){
            $message="Election end date should not be empty!";
        }

        //check start date relative to today
        $start_date_of_election1 = convert_date(try_input($_POST["start_date"]));
        if ($now_date > $start_date_of_election1) {
            $start_date_of_electionErr = "Start date is in the past.";
        } else {
            $start_date_of_election = try_input($_POST["start_date"]);
            //check end date relative to today and then start date
            $end_date_of_election1 = convert_date(try_input($_POST["end_date"]));
            if ($now_date > $end_date_of_election1) {
                $end_date_of_electionErr = "End date is in the past.";
            } elseif ($start_date_of_election1 > $end_date_of_election1) {
                $end_date_of_electionErr = "End date of election cannot be less than the start date.";
            } else {
                $end_date_of_election = try_input($_POST["end_date"]);
                //check time
                $time_of_election_to_temp = getActualtime($_POST["end_time"]);
                $time_of_election_from_temp = getActualtime($_POST["start_time"]);
                if (convert_date($start_date_of_election) === convert_date($end_date_of_election) && convert_date($end_date_of_election) === $now_date) {
                    $time_of_election_from1 = convert_date($time_of_election_from_temp);
                    $time_of_election_to1 = convert_date($time_of_election_to_temp);
                    if ($time_of_election_from1 < $now_time) {
                        $time_of_election_fromErr = "Election holds today but time is in the past.";
                    } else {
                        $time_of_election_from = $time_of_election_from_temp;
                        if ($time_of_election_to1 < $now_time) {
                            $time_of_election_toErr = "Election holds today but time is in the past.";
                        } else {
                            if($time_of_election_to1< $time_of_election_from1){
                                $time_of_election_toErr = "End time of election cannot be less than the start time.";
                            }elseif($time_of_election_to1==$time_of_election_from1 || $time_of_election_to1 < ($time_of_election_from1 + (2*60*60))) {
                                $time_of_election_toErr = "A minimum of 2 hours election duration is required." ;
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
                        $time_of_election_toErr = "End time of election cannot be less than the start time.";
                    }elseif($time_of_election_to1==$time_of_election_from1 || $time_of_election_to1 < ($time_of_election_from1 + (2*60*60))) {
                        $time_of_election_toErr = "A minimum of 2 hours election duration is required." ;
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
        $number_of_new_posts = $_POST["number_of_new_posts"];
        $new_posts = array();
        for($i=0 ; $i<$number_of_new_posts ; $i++){
            $currentPost = 'post' . $i;
            $currentPin = 'pin' . $i;
            $new_posts[$_POST[$currentPin]] = ucwords($_POST[$currentPost]);
        }
        //check if there is no two same posts in the $new_posts.
        if(count(array_unique(array_values($new_posts)))<count(array_values($new_posts))){
            $new_post_Err="Post name should be unique for different posts.<br>";
        }else{
            //check if any post in $new_post is not in $old_post
            $intersection=array_intersect($old_posts,array_values($new_posts));
            if(count($intersection)>0){
                $new_post_Err="One or more of the new posts has already been declared.<br>";
            }
        }
    }
    //check if there is no error message
    if(empty($name_of_electionErr)&&empty($start_date_of_electionErr)&&empty($end_date_of_electionErr)&&empty($time_of_election_fromErr)&&empty($time_of_election_toErr)&&empty($new_post_Err)&&empty($message)){
        //update election name straight away
        $update_name_query="UPDATE election SET election_name='$name_of_election' WHERE election_id='$election_id'";
        mysqli_query($connection2,$update_name_query);
        //check if date and/or time was changed
        if(!empty($_POST["start_date"])&&!empty($_POST["end_date"])&&!empty($_POST["start_time"])&&!empty($_POST["end_time"])){
            $start_date_of_election=explodeDatePicker($start_date_of_election);
            $end_date_of_election=explodeDatePicker($end_date_of_election);
            $update_dateTime_query="UPDATE election
            SET election_start_date='$start_date_of_election',
                election_end_date='$end_date_of_election',
                election_time_from='$time_of_election_from',
                election_time_to='$time_of_election_to'
             WHERE election_id='$election_id'";
            $connection1->query($update_dateTime_query);
        }
        //check if any new post was added
        if(!empty($_POST["number_of_new_posts"])){
            foreach($new_posts as $key => $value){
                $update_post_query="INSERT INTO posts (post_key,post,election_id) VALUES ('$key','$value','$election_id')";
                $connection1->query($update_post_query);
            }
        }
        //check if any of the status was changed
        if($privacy!=$_POST["privacy"] || $openness!=$_POST["openness"]){
            $new_privacy=$_POST["privacy"].$_POST["openness"];
            $status_update_query="UPDATE election SET privacy='$new_privacy' WHERE election_id='$election_id'";
            $connection1->query($status_update_query);
        }
        //check if the time to display result was changed
        if($display!=$_POST["result_display"]){
            $new_time=$_POST["result_display"];
            $connection1->query("UPDATE election SET result_display='$new_time' WHERE election_id='$election_id'");
        }

        //set header to the correct page
        header("Location:postnews.php?key=".$_SESSION['election_id']);
    }

}