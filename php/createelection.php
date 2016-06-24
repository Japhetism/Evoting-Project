<?php
include('session.php');
include_once('function.php');
require_once '../php/csv.php';
include('connection.php');
require_once('../php/database.php');
define('CSV_PATH', '../csv/');
define('MAX_FILE_SIZE', 1024000);

//checking if a user has a photo uploaded before creating election
$upload_photo =$user_id=$var= "";
$csv = 'inactive';
$check_photo = $connection1->prepare("SELECT user_id,picture_name FROM  users WHERE email = '$myemail'");
$check_photo->execute();
$get_photo_name = $check_photo->setFetchMode(PDO::FETCH_ASSOC);
$get_photo_name = $check_photo->fetchAll();
$photo_name = $get_photo_name[0]['picture_name'];
$user_id=$get_photo_name[0]['user_id'];


//check if picture name in the database is null
$images_dir = "../images/users/";
$photo_fetched = "";
$photo_fetched = $images_dir.$photo_name;
if(empty($photo_name) || !file_exists($photo_fetched)){
    $upload_photo = "
                    <div class='row form-group' style='text-align: center'>
                        <div class='col-xs-12'>
                            <label>Picture</label>
                            <div class='input-group'>
                                <input type='file' class='form-control' name='image' id='picture'>
                                <span class='input-group-addon after clear-input' target='#picture' style='background: transparent;border-left: none;padding: 0'>
                                    <i class='fa fa-close'  data-toggle='tooltip'  data-title='clear field'></i>
                                </span>
                            </div>
                        </div>
                        <p id='pic_error1' class='error' style='display:none; color:#ff0000;'>Image formats should be JPG, JPEG,or PNG .</p>
                        <p id='pic_error2' class='error' style='display:none; color:#FF0000;'>Max file size should be 2MB.</p>
                        <p class='help-block'>
                            Pls ensure the file being uploaded is clear picture of yourself.<br>
                        </p>
                    </div><br>";
}


//Declaring variables
$dummy1=$dummy2=$privacy=$dummy3=$dummy4=$dummy5=$parameter='';
$number_of_posts=$number_of_postsErr=$privacyErr=$name_of_electionErr = $start_date_of_electionErr = $end_date_of_electionErr = $time_of_election_fromErr =
$election_pinErr = $time_of_election_toErr =$message=$message2= $result_display="";
$name_of_election = $name_of_election_temp = $start_date_of_election =$start_date_of_election1 = $end_date_of_election =
$end_date_of_election1 = $time_of_election_from = $time_of_election_to = $election_pin =$uploadErr= $success ="";
$last_election_id=0;
$last_post_id=0;
$now_date =convert_date(date("Y-m-d"));
$now_time = convert_date(date("H:i:s"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dummy1=$_POST['start_date'];
    $dummy2=$_POST['end_date'];
    $dummy3=$_POST["name_of_election"];
    $dummy4=$_POST["start_time"];
    $dummy5=$_POST["end_time"];
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

    if (($_POST["start_date"]==='') ) {
        $start_date_of_electionErr = "Start date of election is required.";
    } else {
        $start_date_of_election1 = convert_date(try_input($_POST["start_date"]));
        if ($now_date > $start_date_of_election1) {
            $start_date_of_electionErr = "Start date is in the past.";
        } else {
            $start_date_of_election = try_input($_POST["start_date"]);
        }

    }

    //comparing between start and end date of election
    if (($_POST["end_date"]==='')) {
        $end_date_of_electionErr = "End date of election is required.";
    } else {
        $end_date_of_election1 = convert_date(try_input($_POST["end_date"]));
        if ($now_date > $end_date_of_election1) {
            $end_date_of_electionErr = "End date is in the past.";
        } elseif ($start_date_of_election1 > $end_date_of_election1) {
            $end_date_of_electionErr = "Invalid election duration. End date of election cannot be less than the start date.";
        } else {
            $end_date_of_election = try_input($_POST["end_date"]);
        }

    }

    $time_of_election_from_temp = $time_of_election_to_temp = "";
    if (empty($_POST["number_of_posts"])) {
        $number_of_postsErr = "Number of posts for the election is required.";
    } else {
        $number_of_posts = $_POST["number_of_posts"];

        // adek
        $var = post_pin();
    }

    if ($_POST["end_time"]==='') {
        $time_of_election_toErr = "End time of election is required.";

    } else {
        $time_of_election_to_temp = getActualtime($_POST["end_time"]);

    }

    //if start and end date is same
    if ($_POST["start_time"]==='') {
        $time_of_election_fromErr = "Start time of election is required.";
    } else {
        $time_of_election_from_temp = getActualtime($_POST["start_time"]);
        if (convert_date($start_date_of_election) === convert_date($end_date_of_election) && convert_date($end_date_of_election) === $now_date) {
            $time_of_election_from1 = convert_date($time_of_election_from_temp);
            $time_of_election_to1 = convert_date($time_of_election_to_temp);
            if ($time_of_election_from1 < $now_time) {
                $time_of_election_fromErr = "Election holds today but time is in the past.";
            } elseif($time_of_election_from1<$now_time+(3*60*60)) {
                $time_of_election_fromErr = "Election can only start in 3hours(minimum) time.";
            } else {
                $time_of_election_from = $time_of_election_from_temp;
                if ($time_of_election_to1 < $now_time) {
                    $time_of_election_toErr = "Election holds today but time is in the past.";
                } else {
                    if($time_of_election_to1< $time_of_election_from1){
                        $time_of_election_toErr = "Election holds today.End time cannot be less than the start time.";
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
                $time_of_election_toErr = "Election dates are same.End time cannot be less than the start time.";
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
    //concatenate privacy and openness into $privacy
    $privacy=$_POST["privacy"].$_POST["openness"];



     //validating election result display
    if(empty($_POST['result_display'])){
        $result_display = "after";
    }else{
        $result_display = $_POST['result_display'];
    }


    //validating photo file selected
    if(empty($photo_name) || !file_exists($photo_fetched)){
        //validating photo file selected
        $target_dir = "../images/users/";
        $uploadOK = 0;
        $target_file_temp = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file_temp, PATHINFO_EXTENSION);
        if (!empty($_FILES["image"]["name"])) {
            //$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $currentTime = strtotime(date("Y-m-d")) . "_" . strtotime(date("H:i:s")) . "_" . $user_id . ".";
            $name = $currentTime;
            $target_file = $target_dir . $name . $imageFileType;
            $folderIsWritable = is_writable($target_dir);
            if ($folderIsWritable) {
                if($_FILES["image"]["error"]==1) {
                    $uploadErr = " Size of photo must not exceed 2MB.";
                }elseif($_FILES["image"]["error"]==2) {
                    $uploadErr = "Photo is too big". "(max: 2MB)";
                }elseif($_FILES["image"]["error"]==3) {
                    $uploadErr = "Photo not successfully uploaded.";
                }elseif($_FILES["image"]["error"]==4){
                    $uploadErr ="No file was uploaded.";
                }else if($_FILES["image"]["error"]==6) {
                    $uploadErr= " Sorry temporary folder is missing on our server.";
                }else if($_FILES["image"]["error"]==7) {
                    $uploadErr= " Failed to write file to disk.";
                }else if($_FILES["image"]["error"]==8) {
                    $uploadErr= "A PHP extension stopped the file upload.";
                }else {
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        if (!($imageFileType != 'jpeg' || $imageFileType != "png" || $imageFileType != "jpg")) {
                            $uploadErr = "photo with jpeg, png or jpg extension is allowed.";
                        } elseif (($_FILES["image"]["size"] > 2097152 || $_FILES["image"]["size"] < 20480)) {
                            $uploadErr = "Photo size should be between 20KB and 2MB.";
                        } else {
                            $success = "";
                        }

                    } else {
                        $uploadErr = "File is not an image.";
                    }
                }
            } else {
                trigger_error("Photo cannot be processed.");

                $success = "false";
            }
        } else {
            $uploadErr = "Upload a clear picture of yourself.";
        }

    }
}

$stmt = $connection1->prepare("SELECT  user_id FROM users WHERE email='$myemail'");
$stmt->execute();
$result3 = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result3 = $stmt->fetchAll();
$user_id = $result3[0]["user_id"];

$election_pin = election_pins();
$posts = post_pin();
if(count(array_unique(array_values($posts)))<count(array_values($posts))){
    $message="No two posts can have the same post name.";
}



if ($name_of_election && $start_date_of_election && $end_date_of_election && $time_of_election_from && $time_of_election_to && $privacy != "" && count($posts)!=0) {

    $sql3 = $connection1->prepare("SELECT * FROM election WHERE user_id='$user_id'");
    $sql3->execute();
    $result2=$sql3->setFetchMode(PDO::FETCH_ASSOC);
    $result2=$sql3->fetchAll();
    if(count($result2)<50){

        $sql2 = $connection1->prepare("SELECT * FROM election WHERE election_name='$name_of_election'");
        $sql2->execute();
        $result1=$sql2->setFetchMode(PDO::FETCH_ASSOC);
        $result1=$sql2->fetchAll();
        if(empty($result1)) {

            $csv_name = date('His') . trim($_FILES['election_csv']['name']);
            $csv_type = $_FILES['election_csv']['type'];
            $csv_size = $_FILES['election_csv']['size'];
            $csv_tmp = $_FILES['election_csv']['tmp_name'];
            $csv_ext= strtolower(end(explode('.', $csv_name)));
            $csv_valid_types = array('text/csv', 'application/csv', 'text/comma-separated-values',
                'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'application/octet-stream');

            $target = CSV_PATH . basename($csv_name);
            if(!empty($_FILES['election_csv']['name'])) {
                $csv = 'active';
                if(!is_uploaded_file($csv_tmp)) {
                    $errors[0] = 'Please upload CSV file.';
                }
                elseif($csv_size > MAX_FILE_SIZE) {
                    $errors[] = 'The CSV file must not be greater than ' . (MAX_FILE_SIZE / 1024) . 'KB.';
                }
                elseif(!in_array($csv_type, $csv_valid_types) || $csv_ext !== 'csv')  {
                    $errors[0] = 'Uploaded file must be in the CSV format.';
                }
                elseif(!move_uploaded_file($csv_tmp, $target)) {
                    $errors[] = 'A problem was encountered while processing the uploaded csv file.';
                }

                $csvFields = readCsv($target);
                $field_count = 0;

                if(!$csvFields) {
                    $errors[0] = 'Csv file not readable. Please upload a valid csv file.';
                }
                else {
                    foreach($csvFields as $field) {
                        $field_count = count($field);
                    }
                    if($field_count != 1) {
                        $errors[] = 'Please upload a csv file containing a single column of emails.';
                    }

                    $csvArray = base64url_encode(serialize($csvFields));

                    $emails = array_values_recursive($csvFields);
                    $valid_email_count = 0;
                    if(count($emails) == 0) {
                        $errors[] = 'The uploaded csv file contains no valid email address.';
                    }
                    else {
                        foreach($emails as $row => $email) {
                            if(strpos($email, '@') == false) {
                                $valid_email_count++;
                            }
                        }
                        if($valid_email_count > 1) {
                            $errors[] = 'Please upload a csv file containing email addresses only';
                        }
                    }
                }
            }

            if(empty($uploadErr)) {

                //moving the photo to its directory
                if(empty($photo_name)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {//
                        $picture_name = $name.$imageFileType;
                        $success = "The file was successfully uploaded.";
                        $uploadOK = 1;
                    }
                    else {
                        $success = "The file was not successfully uploaded.";
                        $uploadOK=0;
                    }
                }

                //verify if the picture_name to be keyin to the database is not a space
                if($picture_name != "" ){
                    //update the picture name in the database
                    $sql_picture_name = "UPDATE users SET picture_name = '$picture_name' WHERE email = '$myemail'";
                    $connection1->exec($sql_picture_name);
                }
                $start_date_of_election=explodeDatePicker($start_date_of_election);
                $end_date_of_election=explodeDatePicker($end_date_of_election);
                $sql1 = "INSERT INTO election(election_name, election_start_date, election_end_date, election_time_from, election_time_to, election_pin, user_id, privacy, result_display)
                    VALUES('$name_of_election', '$start_date_of_election', '$end_date_of_election', '$time_of_election_from', '$time_of_election_to', '$election_pin', '$user_id', '$privacy', '$result_display')";
                $connection1->exec($sql1);
                $last_election_id = $connection1->lastInsertId();

                $sql = $connection1->prepare("INSERT INTO posts(post_key, post, election_id)VALUES (:posts_key, :posts_post, :last_election_id)");
                $sql->bindParam(':posts_key', $posts_key_value);
                $sql->bindParam(':posts_post', $posts_post_value);
                $sql->bindParam(':last_election_id', $last_election_id_value);

                foreach ($posts as $key => $value) {
                    $posts_key_value = $key;
                    $posts_post_value = $value;
                    $last_election_id_value = $last_election_id;
                    $sql->execute();
                }
                $last_post_id = $connection1->lastInsertId();

                //csv module
                if(empty($errors) && $csv == 'active') {
                    $select_query = "SELECT email, user_id FROM users";
                    $smh = $connection1->prepare($select_query);

                    if($smh->execute()) {
                        $result = $smh->fetchAll(PDO::FETCH_ASSOC);
                    }

                    $fields = array('user_id', 'email');
                    $valid_voters_id = csv_valid_voters($csvFields, $result, $fields);
                    $_SESSION['csv'] = $csvArray;

                    if($valid_voters_id) {
                        $query_electionId = "SELECT election_id,election_name FROM election WHERE election_pin = '$election_pin'";
                        foreach($result = $connection1->query($query_electionId) as $election) {
                            $election_id = $election['election_id'];
                            $election_name = $election['election_name'];
                        }
                        $result->closeCursor();

                        for($i=0; $i<count($valid_voters_id); $i++) {
                            $valid_voters_id[$i]['election_id'] = $election_id;
                        }

                        $user_id = user_id($myemail);
                        //get admin details for mail sending
                        $administrator = getAllMembers('users',['*'],['user_id','=',$user_id])[0];
                        $sender_name = strtoupper($administrator['fname'])." ".$administrator['lname'];
                        //keep the sender_name and election_name for the ignored guys
                        $_SESSION['sender_name'] = $sender_name;
                        $_SESSION['election_name'] = $election_name;
                        foreach($valid_voters_id as $voter) {
                            if($voter['user_id'] != $user_id) {
                                $insertQuery = "INSERT INTO invites (user_id, election_id) VALUES (:user_id, :election_id)";
                                $smh = $connection1->prepare($insertQuery);
                                //lets forward the invite to the invitee and also send notification to the invitee
                                if ($smh->execute($voter))
                                {
                                    //forward the mail. start by getting sender and receiver first
                                    $recipient = getAllMembers('users',['*'],['user_id','=',$voter['user_id']])[0];
                                    $recipient_name = strtoupper($recipient['fname'])." ".$recipient['lname'];
                                    $mail_subject = "Invitation to join an election - ".$election_name;
                                    $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that ".$sender_name." has invited you to be a voter
                                                in the election named <bold>".$election_name."</bold>. The acceptance of this invitation
                                                makes you a valid voter in the election but if rejected, this invitation will
                                                be removed from the list of your current invitations. Also note that this invitation
                                                will be available for a specified period of time depending on the type of election
                                                which ".$election_name." is. To see more details about this invitation or respond to it,
                                                <a href='evoting.oauife.edu.ng'>Login into your account</a> now.";
                                    sendEmail($recipient['email'],$recipient_name,$mail_subject,$mail_body);
                                }

                            }
                        }
                    }
                }
                else @unlink($target);
            }
        }
        else {
            $message = "Election name already exists.";
        }
    }
    else {
        $message = "You have exceeded the maximum number of election you can create.";
    }
}

if ($last_election_id >0 && $last_post_id > 0 ) {
    $page = 'createelection3.php?election=' . $election_pin . '&csv=' . $csv;
    header('Location: '. $page);
}

//lets regenerate
// $former_posts= post_pin();
// if($number_of_posts !==""){
//     $parameter= 6;

// }

function post_pin()
{
    $posts = $post_namearray =array();
    if (isset($_POST["submit"])) {
        $number_of_posts = $_POST["number_of_posts"];
        for ($i = 0; $i < $number_of_posts; $i++) {
            $currentPost = 'post' . $i;
            $currentPin = 'pin' . $i;
            $name_of_post_temp = trim($_POST[$currentPost]);

            $name_of_post="";
            $post_namearray = explode(" ", ucwords(strtolower($name_of_post_temp)));
            for ($j = 0; $j < count($post_namearray); $j++) {
                if (!empty($post_namearray[$j])) {
                    $name_of_post = $name_of_post . " " . trim($post_namearray[$j]);
                }
                $posts[$_POST[$currentPin]] = trim($name_of_post);
            }
        }
    }

        return $posts;

}
function election_pins(){

    $election_pin_occur=false;
    global $connection1;
    $count=0;
    do{
        $elect_pin =   (range('A','Z')[rand(0,25)]).(range('A','Z')[rand(0,25)]).rand(10, 999999). (range('A','Z')[rand(0,25)]).(range('A','Z')[rand(0,25)]);

            $stmt = $connection1->prepare("SELECT * FROM election WHERE election_pin='$elect_pin'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (empty($result)) {
                return $elect_pin;
            }else{

                $election_pin_occur=true;

            }

    }while($election_pin_occur);

}

function user_id_from_session()
{
        return user_id($_SESSION["login_user"]);
}

?>