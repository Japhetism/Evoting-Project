<?php
include_once('session.php');
include_once('connection.php');
include_once('database.php');
include_once('function.php');
$fname = $lname = $photo = $username = $phone = $password1 = $password2 = $old_password = $sex = $hashed_old_password= $date_diff = "";
$error = $error2 = $mainError = $error3 = "";
$success = $uploadErr ="";
$name = $imageFileType=$contestant_newpicture_name="";
$image_dir = "../images/users/";
$photo = $user_photo = $dir = $dir1 = $dir2 = "";

$userDetails = $connection1->prepare("SELECT * FROM users WHERE email='$myemail'");
$userDetails->execute();
$userDetails->setFetchMode(PDO::FETCH_ASSOC);
$row = $userDetails->fetchAll()[0];
$fname = $row['fname'];
$lname = $row['lname'];
$username = $row['username'];
$phone = $row['phone'];
$sex = $row['gender'];
$photo = $row['picture_name'];
$user_photo = $image_dir.$photo;

if(!file_exists($user_photo) || $photo==NULL){
    if($sex==="male"){
        $user_photo = "../images/male.gif";
    }elseif($sex==="female"){
        $user_photo = "../images/female.png";
    }else{
        $user_photo = "../images/voting1.jpg";
    }
}
//using the function to get the exact name of the photo for default only
$dir = getPhotoName($user_photo);

//saving the given modified useer details to the database
$user_id=user_id($myemail);
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $fname = stripcslashes($_POST["fname"]);
    $lname = stripcslashes($_POST["lname"]);
    $username = stripcslashes($_POST["username"]);
    $old_password = stripcslashes($_POST["old_password"]);
    $password1 = stripcslashes($_POST["password1"]);
    $password2 = stripcslashes($_POST["password2"]);
    $phone = stripcslashes($_POST["phone"]);
    $sex = stripcslashes($_POST["sex"]);

    $error = false;

    if(!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname)){
        $mainError = "Name is not valid, only letters allowed";
        $error = true;
    }

    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $mainError = "Only letters and numbers are required";
        $error = true;
    }

    if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone)) {
        $mainError = "Invalid phone number";
        $error = true;
    }

    if(!empty($password1) && !empty($password2)){
        if($password1<>$password2){
            $mainError = "Password does not match";
            $error = true;
        }else{
            $hashedpassword = md5($password1);
            $error3 = false;
        }
    }

    if(empty($fname) || empty($lname) || empty($username) || empty($phone) || empty($sex)) {
        $mainError = "All fields are required";
        $error = true;
    }

    if(empty($password1) && empty($password2)){
        $error3 = true;
    }

    //hashing of my old password
    if(empty($old_password)){
        $mainError = "Password is required to save changes";
        $error = true;
    }else{
        $hashed_old_password = md5($old_password);
    }
    //validating photo file selected
    $name = $imageFileType=$contestant_newpicture_name=$picture_name=$target_file="";
    if(isset($_FILES["image"])){
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
        }
    }

    //verifying the old password with the password saved in the database
    if(!$error && empty($uploadErr)){

        $result2 =getAllMembers("users",["email","password"],["email","=",$myemail],0,"AND",["password","=",$hashed_old_password]);
        if(count($result2) != 0){
            if(!$error3){
                $query_pass = "UPDATE users SET password='$hashedpassword' WHERE user_id='$user_id'";
                $result_pass = $connection1->query($query_pass);
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {//
                $picture_name = $name.$imageFileType;
                $success = "The file was successfully uploaded";
                $uploadOK = 1;
            } else {
                $success = "The file was not successfully uploaded.";
                $uploadOK=0;
            }


            if($picture_name != "" ){
                //update the picture name in the database
                $query_photo = "UPDATE users SET picture_name = '$picture_name' WHERE user_id = '$user_id'";
                if($connection1->query($query_photo)){
                    if($dir=="users" && $photo!=NULL){
                        unlink($user_photo);
                    }
                }
            }
            $query_update = "UPDATE users SET fname='$fname', lname='$lname', username='$username', phone='$phone', gender='$sex'WHERE user_id='$user_id'";
            if($connection1->query($query_update)){
                header("Location:../html/maindashboard.php");
            }else{

            }

        }else{
            $mainError = "Cannot Authenticate User With The Old Password";
            $error2 = true;
        }
    }
}

?>