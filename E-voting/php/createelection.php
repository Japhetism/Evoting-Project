<?php

include('session.php');
require_once '../php/csv.php';
include('connection.php');
include_once('function.php');
define('CSV_PATH', '../csv/');
define('MAX_FILE_SIZE', 2097152);

//checking if a user has a photo uploaded before creating election
$upload_photo = $user_id="";
$check_photo = $connection1->prepare("SELECT user_id,picture_name FROM  users WHERE email = '$myemail'");
$check_photo->execute();
$get_photo_name = $check_photo->setFetchMode(PDO::FETCH_ASSOC);
$get_photo_name = $check_photo->fetchAll();
$photo_name = $get_photo_name[0]['picture_name'];
$user_id=$get_photo_name[0]['user_id'];

//check if picture name in the database is null
if(empty($photo_name)){
    $upload_photo = "<br><div class='form-group' style='text-align: center'><label>Picture</label>".
        "<input type='file' name='image'></div><br>";
}

//Declaring variables
$uploadErr=$picture_name=$success=$imageFileType="";
$name_of_electionErr = $start_date_of_electionErr = $end_date_of_electionErr = $time_of_election_fromErr =$dummy1=$dummy2=
$election_pinErr = $time_of_election_toErr =$message=$message2= $privacy=$privacyErr="";
$name_of_election = $name_of_election_temp = $start_date_of_election =$start_date_of_election1 = $end_date_of_election =
$end_date_of_election1 = $time_of_election_from = $time_of_election_to = $election_pin = "";
$last_election_id=0;
$last_post_id=0;
$now_date =convert_date(date("Y-m-d"));
$now_time = convert_date(date("H:i:s"));


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($photo_name)){
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
                    $uploadErr = " Size of photo must not exceed 2MB";
                }elseif($_FILES["image"]["error"]==2) {
                    $uploadErr = $_FILES["image"]["name"]. " is too big". "(max: 2MB)";
                }elseif($_FILES["image"]["error"]==3) {
                    $uploadErr = "The uploaded file was only partially uploaded";
                }elseif($_FILES["image"]["error"]==4){
                    $uploadErr ="No file was uploaded";
                }else if($_FILES["image"]["error"]==6) {
                    $uploadErr= " Sorry temporary folder is missing on our server ";
                }else if($_FILES["image"]["error"]==7) {
                    $uploadErr= " Failed to write file to disk.";
                }else if($_FILES["image"]["error"]==8) {
                    $uploadErr= " A PHP extension stopped the file upload.";
               }else {
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        if (!($imageFileType != 'jpeg' || $imageFileType != "png" || $imageFileType != "jpg")) {
                            $uploadErr = "Only images with jpeg, png or jpg is allowed";
                        } elseif (($_FILES["image"]["size"] > 2097152 || $_FILES["image"]["size"] < 20480)) {
                            $uploadErr = "Photo size should be between 20KB and 2MB";
                        } else {
                            $success = "";
                        }

                    } else {
                        $uploadErr = "File is not an image";
                    }
                }
            } else {
                trigger_error("Sorry cannot currently write to folder images");

                $success = "false";
            }
        } else {
            $uploadErr = "No image file has been chosen yet please choose a valid picture.";
        }

    }
   // strtotime(date("Y-m-d"))== (strtotime($election_start) && (strtotime($election_time)-(60*60*3))<strtotime(date("H:i:s")))
    $dummy1=$_POST['start_date'];
    $dummy2=$_POST['end_date'];

    if (empty($_POST["name_of_election"])) {
        $name_of_electionErr = "Name of election is required";
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", try_input($_POST["name_of_election"]))) {
        $name_of_electionErr = "Only letters and white space allowed";
    } else {
        $name_of_election_temp = try_input($_POST["name_of_election"]);
        $election_namearray = array();
        $election_namearray = explode(" ", ucwords($name_of_election_temp));
        for ($i = 0; $i < count($election_namearray); $i++) {
            if (!empty($election_namearray[$i])) {
                $name_of_election = $name_of_election . " " . trim($election_namearray[$i]);
            }
        }
        $name_of_election = trim($name_of_election);
    }

if (($_POST["start_date"]==='') ) {
        $start_date_of_electionErr = "Start date of election is required";
    } else {
        $start_date_of_election1 = convert_date(try_input($_POST["start_date"]));
        if ($now_date > $start_date_of_election1) {
            $start_date_of_electionErr = "Invalid start date of election, date is in the past";
        } else {
            $start_date_of_election = try_input($_POST["start_date"]);
        }

    }

    //comparing between start and end date of election
    if (($_POST["end_date"]==='')) {
        $end_date_of_electionErr = "End date of election is required";
    } else {
        $end_date_of_election1 = convert_date(try_input($_POST["end_date"]));
        if ($now_date > $end_date_of_election1) {
            $end_date_of_electionErr = "Invalid end date of election, date is in the past";
        } elseif ($start_date_of_election1 > $end_date_of_election1) {
            $end_date_of_electionErr = "Invalid election duration, end date of election cannot be less than the start date";
        } else {
            $end_date_of_election = try_input($_POST["end_date"]);
        }

    }

    $time_of_election_from_temp = $time_of_election_to_temp = "";
    if (empty($_POST["number_of_posts"])) {
        $number_of_postsErr = "Number of post for the election is required";
    } else {
        $number_of_posts = $_POST["number_of_posts"];
    }

    if ($_POST["end_hour"]===''|| $_POST["end_minute"]==='') {
        $time_of_election_toErr = "End time of election is required";

    } else {
        $time_of_election_to_temp = $_POST["end_hour"].':'.$_POST["end_minute"].':'.'00';

    }

    //if start and end date is same
    if ($_POST["start_hour"]==='' || $_POST["start_minute"]==='') {
        $time_of_election_fromErr = "start time of election is required";
    } else {
        $time_of_election_from_temp = $_POST["start_hour"].':'.$_POST["start_minute"].':'.'00';
        if (convert_date($start_date_of_election) === convert_date($end_date_of_election) && convert_date($end_date_of_election) === $now_date) {
            $time_of_election_from1 = convert_date($time_of_election_from_temp);
            $time_of_election_to1 = convert_date($time_of_election_to_temp);
            if ($time_of_election_from1 < $now_time) {
                $time_of_election_fromErr = "Invalid time, election date is same, time is in the past ";
            } elseif($time_of_election_from1<$now_time+(3*60*60)) {
                $time_of_election_fromErr = "Invalid time, you can only create an election min of 3 hours into the election ";
            }else{
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
    //validating privacy
    if (empty($_POST["privacy"])) {
        $privacyErr = "Privacy of election is required";
    } else {
        $privacy = $_POST["privacy"];
    }


}

$election_pin = election_pins();
$posts = post_pin();
if(count(array_unique(array_values($posts)))<count(array_values($posts))){
    $message="No two posts can have the same you";
}

    if ($name_of_election && $start_date_of_election && $end_date_of_election && $time_of_election_from && $time_of_election_to && $privacy != "" && count($posts)!=0) {

        $sql3 = $connection1->prepare("SELECT * FROM election WHERE user_id='$user_id'");
        $sql3->execute();
        $result2=$sql3->setFetchMode(PDO::FETCH_ASSOC);
        $result2=$sql3->fetchAll();
        if(count($result2)<12){

            $sql2 = $connection1->prepare("SELECT * FROM election WHERE election_name='$name_of_election'");
            $sql2->execute();
            $result1=$sql2->setFetchMode(PDO::FETCH_ASSOC);
            $result1=$sql2->fetchAll();
            if(empty($result1)){

                $csv_name = date('His') . trim($_FILES['election_csv']['name']);
                $csv_type = $_FILES['election_csv']['type'];
                $csv_size = $_FILES['election_csv']['size'];
                $csv_tmp = $_FILES['election_csv']['tmp_name'];
                $csv_ext= strtolower(end(explode('.', $csv_name)));
                $csv_valid_types = array('text/csv', 'application/csv', 'text/comma-separated-values',
                    'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'application/octet-stream');

                $target = CSV_PATH . basename($csv_name);

                if(!is_uploaded_file($csv_tmp)) {
                    $errors[0] = 'Please upload CSV file';
                }
                elseif($csv_size > MAX_FILE_SIZE) {
                    $errors[] = 'The CSV file must not be greater than ' . (MAX_FILE_SIZE / 1024) . 'KB';
                }
                elseif(!in_array($csv_type, $csv_valid_types) || $csv_ext !== 'csv')  {
                    $errors[0] = 'Uploaded file must be in the CSV format';
                }
                elseif(!move_uploaded_file($csv_tmp, $target)) {
                    $errors[] = 'There was problem uploading your csv file';
                }

                $csvFields = readCsv($target);
                $field_count = 0;

                if(!$csvFields) {
                    $errors[0] = 'Cannot read csv file. Please upload a valid csv file';
                }
                else {
                    foreach($csvFields as $field) {
                        $field_count = count($field);
                    }
                    if($field_count != 1) {
                        $errors[] = 'Please upload a csv file containing emails only';
                    }

                    $csvArray = base64url_encode(serialize($csvFields));

                    $emails = array_values_recursive($csvFields);
                    $valid_email_count = 0;
                    if(count($emails) == 0) {
                        $errors[] = 'The uploaded csv file contains no valid email address';
                    }
                    else {
                        foreach($emails as $row => $email) {
                            if(strpos($email, '@') == false) {
                                $valid_email_count++;
                            }
                        }
                        if($valid_email_count > 1) {
                            $errors[] = 'Please upload a csv file containing email addresses';
                        }
                    }
                }

                $status = array('valid' => false);

                if(empty($errors) && empty($uploadErr) ) {
                    if(empty($photo_name)){
                        //moving the photo to its directory
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            $picture_name = $name . $imageFileType;
                            //$picture_name = basename($_FILES["image"]["name"]);
                            $success = "The file was successfully uploaded";
                            $uploadOK = 1;
                        } else {
                            $success = "The file was not successfully uploaded.";
                            $uploadOK=0;
                        }


                        //verify if the picture_name to be keyin to the database is not a space
                        if($picture_name != "" ){
                            //update the picture name in the database
                            $sql_picture_name = "UPDATE users SET picture_name = '$picture_name' WHERE email = '$myemail'";
                            $connection1->exec($sql_picture_name);
                        }
                    }

                    $start_date_of_election=explodeDatePicker($start_date_of_election);
                    $end_date_of_election=explodeDatePicker($end_date_of_election);

                    $sql1 = "INSERT INTO election(election_name, election_start_date, election_end_date, election_time_from, election_time_to, election_pin, user_id, Privacy)
                    VALUES('$name_of_election', '$start_date_of_election', '$end_date_of_election', '$time_of_election_from', '$time_of_election_to', '$election_pin', '$user_id', '$privacy')";
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
                    $status['valid'] = true;
                    $select_query = "SELECT email, user_id FROM users";
                    $smh = $connection1->prepare($select_query);

                    if($smh->execute()) {
                        $result = $smh->fetchAll(PDO::FETCH_ASSOC);
                    }

                    $fields = array('user_id', 'email');
                    $valid_voters_id = csv_valid_voters($csvFields, $result, $fields);
                    $_SESSION['csv'] = $csvArray;

                    if($valid_voters_id) {
                        $query_electionId = "SELECT election_id FROM election WHERE election_pin = '$election_pin'";
                        foreach($result = $connection1->query($query_electionId) as $election) {
                            $election_id = $election['election_id'];
                        }
                        $result->closeCursor();

                        for($i=0; $i<count($valid_voters_id); $i++) {
                            $valid_voters_id[$i]['election_id'] = $election_id;
                        }

                        foreach($valid_voters_id as $voter) {
                            $insertQuery = "INSERT INTO invites (user_id, election_id) VALUES (:user_id, :election_id)";
                            $smh = $connection1->prepare($insertQuery);
                            $smh->execute($voter);
                        }
                    }
                    else $status['valid'] = false;
                }
                else @unlink($target);
            }
            else {
                $message = "Sorry this election has already been created by another person";
            }
        }else{
            $message = "Sorry the maximum numbers of elections you can create is only five";
        }
    }

    $connection1 = null;


if ($last_election_id >0 && $last_post_id > 0) {
    $status = base64url_encode(serialize($status));
    $page = 'createelection3.php?status=' . $status;
    header('Location: '. $page);
}

function post_pin()
{
    $posts = $post_namearray =array();
    if (isset($_POST["submit"])) {
        $number_of_posts = $_POST["number_of_posts"];
        for ($i = 1; $i <= $number_of_posts; $i++) {
            $currentPost = 'post' . $i;
            $currentPin = 'pin' . $i;
            $name_of_post_temp = trim($_POST[$currentPost]);

            $name_of_post="";
            $post_namearray = explode(" ", ucwords($name_of_post_temp));
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
        try {
            $stmt = $connection1->prepare("SELECT * FROM election WHERE election_pin='$elect_pin'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (empty($result)) {
                return $elect_pin;
            }else{

                $election_pin_occur=true;

            }

        }catch (PDOException $e) {
            echo "connection failed: " . $e->getMessage();
        }

    }while($election_pin_occur);

}

?>

