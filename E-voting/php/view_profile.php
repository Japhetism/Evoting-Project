<?php
include('session.php');
include('connection.php');

$election_id_here= $_SESSION["election_id_view"];

//Declaring variables to be used
$success = $uploadErr ="";
$contestant_post_pin = $user_nickname_here = $user_email =$user_post_here=$user_picture_here =$user_fname=$user_lname=
$election_start =$user_post_id =$user_citation_here =$username=$user_contestant_post=$user_contestant_id=$picture_name=
$user_contestant_id1=$no_of_manifesto_point="";
$manifestos = $manifestos_id =array();

$sql=$connection1->prepare("SELECT fname, lname, username, user_id, phone FROM users WHERE email='$myemail'");
$sql->execute();
$result= $sql->setFetchMode(PDO::FETCH_ASSOC);
$result = $sql->fetchAll();

if(!empty($result)){
    $user_fname= strtoupper($result[0]["fname"]);
    $user_lname=$result[0]["lname"];
    $username = $result[0]["username"];
    $user_id = $result[0]["user_id"];

}else{

}

$sqm = $connection1->prepare("SELECT election_start_date FROM election WHERE election_id='$election_id_here'");
$sqm->execute();
$results = $sqm->setFetchMode(PDO::FETCH_ASSOC);
$results = $sqm->fetchAll();
$election_start = $results[0]["election_start_date"];

$edit_nick_nameErr=$edit_nick_name = $update_election_message="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (strtotime(date("Y-m-d")) < (strtotime($election_start) - (60 * 60 * 24))) {
        //Nick name validation
        if (!empty($_POST["nick_name"])) {

            $edit_nick_name = stripslashes(trim($_POST["nick_name"]));

            $sql5 = "UPDATE contestants SET nickname='$edit_nick_name' WHERE user_id='$user_id' AND election_id='$election_id_here'";
            $connection1->exec($sql5);

        }
        $sql7 = $connection1->prepare("SELECT contestant_id FROM contestants WHERE user_id='$user_id' AND election_id='$election_id_here'");
        $sql7->execute();
        $result6 = $sql7->setFetchMode(PDO::FETCH_ASSOC);
        $result6 = $sql7->fetchAll();
        $user_contestant_id1 = $result6[0]["contestant_id"];

        $sql6 = $connection1->prepare("SELECT manifesto_id FROM manifesto WHERE contestant_id= '$user_contestant_id1'");
        $sql6->execute();
        $result5 = $sql6->setFetchMode(PDO::FETCH_ASSOC);
        $result5 = $sql6->fetchAll();
        for ($j = 0; $j < count($result5); $j++) {
            $manifestos_id[$j] = $result5[$j]['manifesto_id'];
        }

        $stm = "stm";
        $manifestos_id_key = '';
        for ($i = 0; $i < count($result5); $i++) {
            $point = "manifesto" . $i;
            $sqm = $stm . $i;
            $manifestos_id_key = $manifestos_id[$i];
            if (isset($_POST[$point])) {
                if (!empty($_POST[$point])) {
                    $edit_manifestos = ucfirst($_POST[$point]);
                    echo $edit_manifestos;
                    $$sqm = "UPDATE manifesto SET manifesto='$edit_manifestos' WHERE manifesto_id='$manifestos_id[$i]'";
                    $connection1->exec($$sqm);
                }
            }
        }

        $name = $imageFileType=$contestant_newpicture_name="";
        if (isset($_POST["submit"])) {
            $target_dir = "../images/contestants/";
            $uploadOK = 0;
            if (!empty($_FILES["image"]["name"])) {
                $target_file_temp = $target_dir . basename($_FILES["image"]["name"]);
                $imageFileType = pathinfo($target_file_temp, PATHINFO_EXTENSION);
                $currentTime = strtotime(date("Y-m-d")) . "_" . strtotime(date("H:i:s")) . "_" . $user_id . ".";
                $name = $currentTime;
                $target_file = $target_dir . $name . $imageFileType;
                $folderIsWritable = is_writable($target_dir);
                if ($folderIsWritable) {
                    if ($_FILES["image"]["error"] == 1) {
                        $uploadErr = " Your file size execeed the maximum file size on the localhost only images with minimum size of 20kb and max size of 500kb are allowed";
                    } else if ($_FILES["image"]["error"] == 6) {
                        $uploadErr = " Sorry temporary folder is missing on our server ";
                    } else {
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if ($check !== false) {
                            //$uploadErr = "File is an image " . $check["mime"];
                            if (!($imageFileType != 'jpeg' || $imageFileType != "png" || $imageFileType != "jpg")) {
                                $uploadErr = "Only images with jpeg, png, or jpg is allowed";

                            } elseif (($_FILES["image"]["size"] < (20480))) {
                                $uploadErr = "Only images with minimum size of 20kb and max size of 2MB are allowed";

                            } else {
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    $contestant_newpicture_name = $name . $imageFileType;
                                    $success = "The file was successfully uploaded";
                                    $sql8 = "UPDATE contestants SET picture_name='$contestant_newpicture_name' WHERE user_id='$user_id' AND election_id='$election_id_here'";
                                    $connection1->exec($sql8);

                                }else{
                                    $success = "The file was not successfully uploaded";
                                }
                            }

                        } else {
                            $uploadOK = 0;
                            $uploadErr = "File is not an image";
                        }
                    }

                } else {
                    trigger_error("Sorry cannot currently write to folder images");

                    $success = "false";
                }
            }

        }

    } else {
        $update_election_message="You can only edit your contestant profile 24 hours more into the election";
    }
}

$images_dir="../images/contestants/";

$sql1 =$connection1->prepare("SELECT contestant_id, picture_name, citation_name, post_id, nickname, election_id FROM contestants WHERE user_id='$user_id' AND election_id='$election_id_here'");
$sql1->execute();
$result1= $sql1->setFetchMode(PDO::FETCH_ASSOC);
$result1 = $sql1->fetchAll();
if(empty($result1)) {
    $key=  rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$_SESSION["election_id"].rand(10000,99999).rand(100,999);

    header("Location:election_detailsNews.php?key=".$key) ;
}

$user_nickname_here = $result1[0]["nickname"];
$picture_name = $result1[0]["picture_name"];
$user_picture_here = $images_dir .$picture_name;
$user_post_id = $result1[0]["post_id"];
$user_citation_here = $result1[0]["citation_name"];
$user_contestant_id = $result1[0]["contestant_id"];
$contestant_election_id = $result1[0]["election_id"];


$sql2 = $connection1->prepare("SELECT * FROM manifesto WHERE contestant_id='$user_contestant_id'");
$sql2->execute();
$result2 = $sql2->setFetchMode(PDO::FETCH_ASSOC);
$result2 = $sql2->fetchAll();
for ($j = 0; $j < count($result2); $j++) {
    $manifestos[$j] = $result2[$j]['manifesto'];
    $manifestos_id[$j] = $result2[$j]['manifesto_id'];

}

$no_of_manifesto_point=count($manifestos);

$sql3 = $connection1->prepare("SELECT post, post_key FROM posts WHERE post_id='$user_post_id'");
$sql3->execute();
$result3 = $sql3->setFetchMode(PDO::FETCH_ASSOC);
$result3 = $sql3->fetchAll();
$user_contestant_post = $result3[0]["post"];
$contestant_post_pin = $result3[0]["post_key"];

$sql4 = $connection1->prepare("SELECT election_name FROM election WHERE election_id='$election_id_here'");
$sql4->execute();
$result4 = $sql4->setFetchMode(PDO::FETCH_ASSOC);
$result4 = $sql4->fetchAll();
$contestant_election_name = $result4[0]["election_name"];


if($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["delete"])) {
        $sqm1 = "DELETE FROM manifesto WHERE contestant_id='$user_contestant_id'";
        $connection1->exec($sqm1);

        $sqm2 = "DELETE FROM contestants WHERE contestant_id='$user_contestant_id'";
        $connection1->exec($sqm2);
        $key=rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$_SESSION['election_id'].rand(10000,99999).rand(100,999);

        header("Location:election_detailsNews.php?key=".$key);
    }
}
//$dum=$_SESSION['election_id'];
?>
