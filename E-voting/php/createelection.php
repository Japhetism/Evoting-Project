<?php
//include('session.php');
require_once '../php/csv.php';
//include('connection.php');
define('CSV_PATH', '../csv/');
define('MAX_FILE_SIZE', 1024000);

session_start();

if(isset($_SESSION['login_user'])){
    $myemail = $_SESSION['login_user'];
}

//validation and database

function test_inputs($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// php function that convert date to its corresponding timestamp
function convert_date($date){
    $date = strtotime($date);
    return $date;
}



function post_pin()
{
    $posts = array();
    if (isset($_POST["submit"])) {
        $number_of_posts = $_POST["number_of_posts"];
        for ($i = 1; $i <= $number_of_posts; $i++) {
            $currentPost = 'post' . $i;
            $currentPin = 'pin' . $i;
            $posts[$_POST[$currentPin]] = $_POST[$currentPost];
        }
    }
    return $posts;

}

function election_pins(){
    $serverName = "localhost";
    $userName = "root";
    $password = "eminence";
    $election_pin_occur=true;
//    global $connection1;

    do{
        $elect_pin = "0" . rand(01, 9) . " - " . rand(1000, 9999);
        try {
            $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT election_pin FROM election");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (count($result)!=0) {

                for($i=0;$i<count($result);$i++){
                    if($result[$i]["election_pin"]!=$elect_pin){
                        $election_pin_occur=false;
                        return $elect_pin;
                    }else{
                        $election_pin_occur=true;
                    }

                }
            }else{
                return $elect_pin;
            }

        }catch (PDOException $e) {
            //echo "connection failed: " . $e->getMessage();
        }

    }while($election_pin_occur);

}

function user_id_from_session()
{
//    global $connection1;
    $serverName = "localhost";
    $userName = "root";
    $password = "eminence";
    try {
        $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $email = $_SESSION["login_user"];
        $stmt = $conn->prepare("SELECT  user_id FROM users WHERE email='$email'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]["user_id"];

    } catch (PDOException $e) {
        //echo "connection failed: " . $e->getMessage();
    }
}

function check_election_in_database($election_name, $election_date, $user_id, $posts){
    $serverName = "localhost";
    $userName = "root";
    $password = "eminence";
//    global $connection1;

    try{
        $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "connected successfully";
        $sql = $conn->prepare("SELECT election_id, election_name, election_start_date, date_created, user_id FROM election");
        $sql->execute();
        $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();
        if(count($result)!=0){
            $i=0;
            while($i<count($result)){
                $election_id_value=$result[$i]["election_id"];
                $sql2= $conn->prepare("SELECT post FROM posts WHERE election_id= '$election_id_value'");
                $sql2->execute();
                $result2 = $sql2->setFetchMode(PDO::FETCH_ASSOC);
                $result2 = $sql2->fetchAll();
                foreach($posts as $key=>$value){
                    if(strtolower($value)== strtolower($result2[$i]["post"])&& $election_name ==
                        strtoupper($result[$i]["election_name"])&& $user_id==$result[$i]["user_id"]&& strtotime($election_date)==
                        strtotime($result[$i]["election_start_date"])){
                        $answer = "true";
                        return $answer;
                    }elseif(strtolower($value)== strtolower($result2[$i]["post"])&& $election_name==
                        strtoupper($result[$i]["election_name"]) && $user_id!=$result[$i]['user_id']&& strtotime($election_date)==
                        strtotime($result[$i]['election_start_date'])){
                        $user_id_value=$result[$i]["user_id"];
                        $sql3 = $conn->prepare("SELECT fname, lname FROM users WHERE user_id = '$user_id_value'");
                        $sql3->execute();
                        $result3 = $sql3->setFetchMode(PDO::FETCH_ASSOC);
                        $result3 = $sql3->fetchAll();
                        $answer = "The Election ". $result[$i]['election_name']. " has been created by ". $result3[0]['fname'] ." ". $result3[0]['lname']." on ". $result[$i]['date_created'];
                        return $answer;
                    }else{
                        $answer = "false";
                        return $answer;
                    }
                }
                $i++;
            }
        }else{
            $answer="false";
            return $answer;
        }
    }catch(Exception $e){
        //echo "connection failed ". $e->getMessage();
    }
}


//Declaring variables
$name_of_electionErr = $start_date_of_electionErr = $end_date_of_electionErr = $time_of_election_fromErr = $election_pinErr = $time_of_election_toErr =$message=$message2= "";
$name_of_election = $start_date_of_election =$start_date_of_election1 = $end_date_of_election =  $end_date_of_election1 = $time_of_election_from = $time_of_election_to = $election_pin = "";
$last_election_id=0;
$last_post_id=0;
$now_date =convert_date(date("Y-m-d"));
//$now_time = convert_date(date("h:i"));


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name_of_election"])) {
        $name_of_electionErr = "Name of election is required";
    } else if (!preg_match("/^[a-zA-Z ]*$/", test_inputs($_POST["name_of_election"]))) {
        $name_of_electionErr = "Only letters and white space allowed";
    } else {
        $name_of_election = test_inputs($_POST["name_of_election"]);
    }

    if (empty($_POST["start_date_of_election"])) {
        $start_date_of_electionErr = "Start date of election is required";
    } else {
        $start_date_of_election1 = convert_date(test_inputs($_POST["start_date_of_election"]));
        if($now_date > $start_date_of_election1){
            $start_date_of_electionErr = "Time is in the past";
        }else{
            $start_date_of_election = test_inputs($_POST["start_date_of_election"]);
        }

    }

    if (empty($_POST["end_date_of_election"])) {
        $end_date_of_electionErr = "End date of election is required";
    } else {
        $end_date_of_election = test_inputs($_POST["end_date_of_election"]);
        $end_date_of_election1 = convert_date($end_date_of_election);
        if($now_date > $end_date_of_election1){
            $end_date_of_electionErr = "Time is in the past";
        }


        //comparing between start and end date of election
        if($start_date_of_election1 > $end_date_of_election1){
            $end_date_of_electionErr = "Invalid election duration";
        }else{
            $end_date_of_electionErr = "";
        }
    }



    if (empty($_POST["time_of_election_from"])) {
        $time_of_election_fromErr = "start time of election is required";
    } else {
        $time_of_election_from = test_inputs($_POST["time_of_election_from"]);
        //$time_of_election_from1 = convert_date($time_of_election_from);
    }

    if (empty($_POST["time_of_election_to"])) {
        $time_of_election_toErr = "End time of election is required";

    } else {
        $time_of_election_to = test_inputs($_POST["time_of_election_to"]);
        // $time_of_election_to1 = convert_date($time_of_election_to);
    }


    //if start and end date is same
    if($start_date_of_election1 == $end_date_of_election1){
        $time_of_election_from1 = convert_date($time_of_election_from);
        $time_of_election_to1 = convert_date($time_of_election_to);
        if($time_of_election_from1 > $time_of_election_to1){
            $time_of_election_toErr = "Invalid time, election date is same";
        }
    }

    $serverName = "localhost";
    $userName = "root";
    $password = "eminence";
    $election_pin = election_pins();
    $date_created = date('Y-m-d');
    $user_id = user_id_from_session();
    $posts = post_pin();

    try {
        $conn = new PDO("mysql:host=$serverName; dbname=eVoting", $userName, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($name_of_election && $start_date_of_election && $end_date_of_election && $time_of_election_from && $time_of_election_to != "" && count($posts)!=0) {

            if(check_election_in_database($name_of_election, $start_date_of_election, $user_id, $posts)=="true"){
                $message="This election has already been created by you";
            }elseif(check_election_in_database($name_of_election, $start_date_of_election, $user_id, $posts)=="false") {
                $csv_name = date('His') . trim($_FILES['election_csv']['name']);
                $csv_type = $_FILES['election_csv']['type'];
                $csv_size = $_FILES['election_csv']['size'];
                $csv_tmp = $_FILES['election_csv']['tmp_name'];
                $csv_arr= explode('.', $csv_name);
                $csv_ext= strtolower(array_pop($csv_arr));
                $csv_valid_types = array('text/csv', 'text/plain', 'application/csv', 'text/comma-separated-values',
                    'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel',
                    'text/anytext', 'application/octet-stream', 'application/txt');

                $target = CSV_PATH . basename($csv_name);

                if(!is_uploaded_file($csv_tmp)) {
                    $errors[] = 'Please upload CSV file';
                }
                elseif($csv_size > MAX_FILE_SIZE) {
                    $errors[] = 'The CSV file must not be greater than ' . (MAX_FILE_SIZE / 1024) . 'KB';
                }
                elseif(!in_array($csv_type, $csv_valid_types) || $csv_ext !== 'csv')  {
                    $errors[] = 'Uploaded file must be in the CSV format';
                }
                elseif(!move_uploaded_file($csv_tmp, $target)) {
                    $errors[] = 'There was problem uploading your csv file';
                }

                $csvFields = readCsv($target);
                $field_count = 0;

                if(!$csvFields) {
                    $errors[] = 'Cannot read csv file. Please upload a valid csv file';
                }
                else {
                    foreach($csvFields as $field) {
                        $field_count = count($field);
                    }
                    if($field_count != 1) {
                        $errors[] = 'Please upload a csv file containing emails only';
                    }
                }

                if(empty($errors)) {
                    $sql1 = "INSERT INTO election(election_name, election_start_date, election_end_date, election_time_from, election_time_to, election_pin, user_id)
                    VALUES('$name_of_election', '$start_date_of_election', '$end_date_of_election', '$time_of_election_from', '$time_of_election_to', '$election_pin', '$user_id')";
                    $conn->exec($sql1);
                    $last_election_id = $conn->lastInsertId();

                    $sql = $conn->prepare("INSERT INTO posts(post_key, post, election_id)VALUES (:posts_key, :posts_post, :last_election_id)");
                    $sql->bindParam(':posts_key', $posts_key_value);
                    $sql->bindParam(':posts_post', $posts_post_value);
                    $sql->bindParam(':last_election_id', $last_election_id_value);

                    foreach ($posts as $key => $value) {
                        $posts_key_value = $key;
                        $posts_post_value = $value;
                        $last_election_id_value = $last_election_id;
                        $sql->execute();
                    }
                    $last_post_id = $conn->lastInsertId();

                    //csv module

                    $select_query = "SELECT email, user_id FROM users";
                    $smh = $conn->prepare($select_query);

                    if ($smh->execute()) {
                        $result = $smh->fetchAll(PDO::FETCH_ASSOC);
                    }

                    $fields = array('user_id', 'email');
                    $valid_voters_id = csv_valid_voters($csvFields, $result, $fields);

                    if ($valid_voters_id) {
                        $query_electionId = "SELECT election_id FROM election WHERE election_pin = '$election_pin'";
                        foreach ($conn->query($query_electionId) as $election) {
                            $election_id = $election['election_id'];
                        }

                        for ($i = 0; $i < count($valid_voters_id); $i++) {
                            $valid_voters_id[$i]['election_id'] = $election_id;
                        }

                        foreach ($valid_voters_id as $voter) {
                            $insertQuery = "INSERT INTO joined (user_id, election_id) VALUES (:user_id, :election_id)";
                            $smh = $conn->prepare($insertQuery);
                            $smh->execute($voter);
                        }
                        $valid_users_emails = csv_valid_voters($csvFields, $result, $fields, 1);
                    } else @unlink($target);
                }
            }else {
                $message = check_election_in_database($name_of_election, $start_date_of_election, $user_id, $posts);
            }
        }


    }
    catch (PDOException $e) {
        echo "connection failed: " . $e->getMessage();
    }


    $conn = null;
}

if ($last_election_id >0 && $last_post_id > 0) {
    $v_voters = base64url_encode(serialize($valid_voters_id));
    $v_users = base64url_encode(serialize($valid_users_emails));
    $page = 'createelection3.php?inid=' . $v_voters . '&notinid=' . $v_users;
    header('Location: ' . $page);

}else{
//    $message2= "Election creation is Unsuccessful please fill in the necessary fields and try again";
}

?>