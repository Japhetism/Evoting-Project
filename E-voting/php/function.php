<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/9/16
 * Time: 11:52 AM
 */

function dateString($date){
    $year=explode("-",$date)[0];
    $month= explode("-",$date)[1];
    $day= explode("-",$date)[2];
    if(substr($month,0,1)===0){
        $month= substr($month,1,1);
    }
    //decide month
    $string= array('Jan.','Feb.','March','April','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec.');
    $month_string=$string[$month-1];
    return $day.' '.$month_string.', '.$year.'.';
}

function timeString($time){
    $session= 'AM';
    $hour= explode(':',$time)[0];
    $min = explode(':',$time)[1];
    if($hour>11){
        $session='PM';
    }
    if($hour>12){
        $hour=$hour-12;
        if($hour<10){
            $hour='0'.$hour;
        }
    }

    return $hour.':'.$min.''.$session;
}

function try_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function convert_date($date){
    $date = strtotime($date);
    return $date;
}

function explodeDatePicker($date){
    $array= explode('/',$date);
    return $array[2].'-'.$array[0].'-'.$array[1];
}

function picture($dir){
    $name =$uploadErr="";
    if (isset($_POST["submit"])) {
        $target_dir = $dir;
        if (!empty($_FILES["image"]["name"])) {
            $target_file_temp = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file_temp, PATHINFO_EXTENSION);
            $folderIsWritable = is_writable($target_dir);
            if ($folderIsWritable) {
                if($_FILES["image"]["error"]==1) {
                    $uploadErr = " Size of photo must not exceed 2MB";
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
                }else{
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadErr = "File is an image " . $check["mime"];
                        if (!($imageFileType != 'jpeg' || $imageFileType != "png" || $imageFileType != "jpg")) {
                            $uploadErr = "Only images with jpeg, png, or jpg is allowed";

                        } elseif (( $_FILES["image"]["size"] =="")) {
                            $uploadErr = "Size of photo must not be less than 20kb ";

                        } else {
                            $success = "";
                        }

                    } else {

                        $uploadErr = "File is not an image";
                    }
                }
                return $uploadErr;

            } else {
                trigger_error("Sorry cannot currently write to folder images");

                $success = "false";
            }
        } else {
            $uploadErr = "No image file has been chosen yet please choose a valid picture.";
            return $uploadErr;

        }

    }
}

//lets check if a particular election is totally public for a user,put this in function.php
function publicDisplayable($user_id,$election_id){
    $table_lists=array('election','joined','invites','request');
    $publicity='totally';
    for($i=0;$i<count($table_lists);$i++){
        $attached=attached($table_lists[$i],$user_id,$election_id);
        if(!empty($attached)){
            $publicity= 'partially';
            break;
        }
    }
    return $publicity;
}

//function to remove spaces between words
function removeSpace($value){
    $data="";
    $dataarray= array();
    $dataarray = explode(" ", ucwords($value));
    for ($i = 0; $i < count($dataarray); $i++) {
        if (!empty($dataarray[$i])) {
            $data =$data.trim($dataarray[$i]);
        }
    }
    return trim($data);
}