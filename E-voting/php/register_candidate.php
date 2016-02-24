<?php
include_once('session.php');
include_once('connection.php');
include_once('database.php');

$postString=$contestant_fname =$contestant_lname =$contestant_username= $user_id= $contestant_election_id =$result2=$election_start="";

if(empty($_SESSION["election_id_view"])) {
    header("Location:maindashboard.php");
}
$contestant_election_id =  $_SESSION["election_id_view"];

$sql= $connection1->prepare("SELECT * FROM joined WHERE election_id ='$contestant_election_id'");
$sql->execute();
$result= $sql->setFetchMode(PDO::FETCH_ASSOC);
$result = $sql->fetchAll();

$sql1 = $connection1->prepare("SELECT fname, lname, username, user_id FROM users WHERE email='$myemail'");
$sql1->execute();
$result1 = $sql1->setFetchMode(PDO::FETCH_ASSOC);
$result1 = $sql1->fetchAll();
if (!empty($result1)) {
    $contestant_fname = $result1[0]["fname"];
    $contestant_lname = $result1[0]["lname"];
    $contestant_username = $result1[0]["username"];
    $user_id= $result1[0]["user_id"];

} else {
    $problem = "Your name cannot be found in our database";
}

$sql6 = $connection1->prepare("SELECT election_start_date FROM election WHERE election_id='$contestant_election_id'");
$sql6->execute();
$result5 = $sql6->setFetchMode(PDO::FETCH_ASSOC);
$result5 = $sql6->fetchAll();
$election_start = $result5[0]["election_start_date"];

$sql2 = $connection1->prepare("SELECT post_id, post, post_key FROM  posts WHERE election_id='$contestant_election_id'");
$sql2->execute();
$result2 = $sql2->setFetchMode(PDO::FETCH_ASSOC);
$result2 = $sql2->fetchAll();

//Declaring variables to be used
$allPost=$nick_name = $no_manifesto_points= $contestant_post=$contestant_pin= $errors= $contestant_post_temp=$contestant_pin_temp="";
$uploadErr = $nick_nameErr =$contestant_postErr=$contestant_pinErr=$no_manifesto_pointsErr= $uploadCitationErr="";
$success= $successC=$contestant_picture_name = $contestant_citation_name = $imageFileType=$citationFileType="";
$last_contestant_id=0;
$last_manifesto_id=0;
$registration_message="";

if(strtotime(date("Y-m-d"))< (strtotime($election_start)-(60*60*24))){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Nick name validation
        if (empty($_POST["nick_name"])) {
            $nick_nameErr = "Nick name(political name) cannot be empty";
        } elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST["nick_name"])) {
            $nick_nameErr = "Nick name with only letters and numbers are allowed";
        } else {
            $nick_name = trim(ucwords($_POST["nick_name"]));
        }

        //contestants post and pin validation
        if (empty($_POST["contestant_post"])) {
            $contestant_postErr = "The contestants post field cannot be empty";
        } else {
            $contestant_post_temp = trim($_POST["contestant_post"]);
        }
        if (empty($_POST["contestant_pin"])) {
            $contestant_pinErr = "The contestants pin field cannot be empty";
        } else {
            $contestant_pin_temp = trim($_POST["contestant_pin"]);
        }

        //Checking if the contestants input post and pin are valid
        if ($contestant_pin_temp !== "" && $contestant_post_temp !== "") {
            if (!empty($result2)) {
                for ($i = 0; $i < count($result2); $i++) {
                    if (strtolower($result2[$i]['post']) == strtolower($contestant_post_temp) &&
                        $result2[$i]["post_key"] == $contestant_pin_temp
                    ) {
                        $contestant_pin = $contestant_pin_temp;
                        $contestant_post = $contestant_post_temp;
                        $contestant_post_id = $result2[$i]["post_id"];
                    }
                }
                if (empty($contestant_pin) && empty($contestant_post)) {
                    $errors = "Invalid pin or post! please contact
                                    the admin of this election for valid pin or post";
                }
            } else {
                $errors = "Sorry there was a problem reading from the database";
            }
        }

        //validating the number of manifesto points
        if (empty($_POST["manifesto_points"])) {
            $no_manifesto_pointsErr = "The manifesto points field cannot be empty";
        } elseif ($_POST["manifesto_points"] > 7) {
            $no_manifesto_pointsErr = "Your manifesto points cannot be greater than 7";
        } else {
            $no_manifesto_points = $_POST["manifesto_points"];
        }


        //picture upload validation
        $name = "";
        if (isset($_POST["submit"])) {
            $target_dir = "../images/contestants/";
            $currentTime = strtotime(date("Y-m-d")) . "_" . strtotime(date("H:i:s")) . "_" . $user_id . ".";
            $name = $currentTime;
            $target_file_temp = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file_temp, PATHINFO_EXTENSION);
            $target_file = $target_dir . $name . $imageFileType;
            $uploadErr= picture($target_dir);
            $currentTime = strtotime(date("Y-m-d")) . "_" . strtotime(date("H:i:s")) . "_" . $user_id . ".";
            $name = $currentTime;
             $target_file_temp = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file_temp, PATHINFO_EXTENSION);

            //citation file validation
            $citation_target_dir = "../contestant_citation/";
            $uploadCOK = 0;
            if (!empty($_FILES["citation"]["name"])) {
                $target_cfile_temp = $citation_target_dir . basename($_FILES["citation"]["name"]);
                $citationFileType = pathinfo($target_cfile_temp, PATHINFO_EXTENSION);
                $target_cfile = $citation_target_dir . $name . $citationFileType;
                $folderIsWritable = is_writable($citation_target_dir);
                if ($folderIsWritable) {
                    if (($citationFileType != 'pdf')) {
                        $uploadCitationErr = "Only pdf files are allowed";
                        $uploadCOK = 0;
                    } elseif (!($_FILES["citation"]["size"] > 0 && $_FILES["citation"]["size"] < 10485760)) {
                        $uploadCitationErr = "Only files with less than 10MB are allowed";

                    } else {
                        $successC = "";
                    }

                } else {
                    trigger_error("Sorry cannot currently write to folder contestants citation");

                }

            }

        }


    }
}elseif(strtotime(date("Y-m-d"))== (strtotime($election_start)-(60*60*24))){
    $registration_message = "Sorry this election will commence in the next 24 hours therefore your request cannot be processed.";
}else{
    $registration_message = "This election has already been concluded therefore your request cannot be processed" ;
}

$stmt = $connection1->prepare("SELECT  user_id FROM users WHERE email='$myemail'");
$stmt->execute();
$result4 = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result4 = $stmt->fetchAll();

//storing details in the database
$manifesto_point=manifesto_points($no_manifesto_points); $user_id="";
$user_id = $result4[0]["user_id"];
if($nick_name != "" && $manifesto_point!="" && $contestant_pin!="" && $contestant_post!= "" ) {

    //To check if the contestants has already registered for this election
    $sql5 = $connection1->prepare("SELECT * FROM contestants WHERE user_id='$user_id' AND election_id='$contestant_election_id'");
    $sql5->execute();
    $result3 = $sql5->setFetchMode(PDO::FETCH_ASSOC);
    $result3 = $sql5->fetchAll();

    //if the contestants has not registered as a candidate to contest for the election validate picture and store his details.
    if (empty($result3)) {
        //if picture upload his OK store the contestants details in the database
        if ($uploadCitationErr == "" && $uploadErr == "") {

            if (!empty($_FILES["citation"]["name"])){
                if (move_uploaded_file($_FILES["citation"]["tmp_name"], $target_cfile)) {
                    $contestant_citation_name = $name . $citationFileType;
                    $successC = "The file was successfully uploaded";
                    $uploadCOK = 1;
                } else {
                    $successC = "The file was not successfully uploaded.";
                }
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $contestant_picture_name = $name.$imageFileType;
                $success = "The file was successfully uploaded";
                $uploadOK = 1;
            } else {
                $success = "The file was not successfully uploaded.";
                $uploadOK=0;
            }

            if ($uploadOK = 1 && ($uploadCOK == 1 || $uploadCOK==0)) {
                $sql3 = "INSERT INTO contestants(picture_name, nickname, post_id, election_id, citation_name, user_id) VALUES('$contestant_picture_name', '$nick_name', '$contestant_post_id', '$contestant_election_id', '$contestant_citation_name', '$user_id') ";
                $connection1->exec($sql3);
                $last_contestant_id = $connection1->lastInsertId();

                $sql4 = $connection1->prepare("INSERT INTO manifesto(manifesto, contestant_id)VALUES (:manifesto, :contestant_id)");
                $sql4->bindParam(':manifesto', $manifesto_value);
                $sql4->bindParam(':contestant_id', $contestant_id_value);

                for ($i = 1; $i <= count($manifesto_point); $i++) {
                    $manifesto_value = $manifesto_point[$i];
                    $contestant_id_value = $last_contestant_id;
                    $sql4->execute();
                }
                $last_manifesto_id = $connection1->lastInsertId();

                if ($last_contestant_id > 0 && $last_manifesto_id > 0) {
                    header("Location:viewcontestant.php") ;
                }
            }else{
                echo "Sorry an error occur while inserting your details in the database please try again.";
            }
        }

    } else {
        $registration_message = "You are already a contestant in this election, you cannot register for a post twice or another post.";
    }

}
//get the available posts and print in a select button
$allPost=getAllPosts($contestant_election_id);
$postString.="<select name='contestant_post'>";
$postString.="<option value=''></option>";
for($i=0;$i<count($allPost);$i++){
    $postString.="<option value=".$allPost[$i]['post'].">".ucwords($allPost[$i]['post'])."</option>";
}
$postString.="</select>";

//function to store manifesto point in an array
function manifesto_points($no_points){
    $points = array();
    if(isset($_POST["submit"])){
        if($no_points>0 && $no_points<=7) {
            for ($i = 1; $i <= $no_points; $i++) {
                $manifestoPoint = 'point' . $i;
                $points[$i] = ucfirst($_POST[$manifestoPoint]);
            }
        }else{
            return $points;
        }
    }
    return $points;
}


?>

