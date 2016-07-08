<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/9/16
 * Time: 11:52 AM
 */
require_once "../PHPMailer/vendor/autoload.php";


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
    return $day.' '.$month_string.', '.$year;
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
function changeDateFormat($dates){
    $array= explode('-',$dates);
    return $array[0].'/'.$array[1].'/'.$array[2];
}

function picture($dir){
    $uploadErr="";
    if (!empty($_FILES["image"]["name"])) {
        $target_file_temp = $dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file_temp, PATHINFO_EXTENSION);
        $folderIsWritable = is_writable($dir);
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
            }else{
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    //$uploadErr = "File is an image " . $check["mime"];
                    if (!($imageFileType != 'jpeg' || $imageFileType != "png" || $imageFileType != "jpg")) {
                        $uploadErr = "Only images with jpeg, png, or jpg is allowed";

                    } elseif (( $_FILES["image"]["size"] < 20480)) {
                        $uploadErr = "Size of photo must not be less than 20kb ";

                    } else {
                        $success = "";
                    }

                } else {
                    $uploadErr = "File is not an image";
                }
            }
//            return $uploadErr;

        } else {
            trigger_error("Sorry cannot currently write to folder images");
            $uploadErr = "Sorry cannot currently write to folder images";

        }
    } else {
        $uploadErr = "No image file has been chosen yet please choose a valid picture.";
//        return $uploadErr;

    }
    return $uploadErr;
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

//function to check if an election has concluded
function concluded($date,$time,$lag){
    if( (strtotime(date("Ymd"))>strtotime(date($date))) | ( (strtotime(date("Ymd"))==strtotime(date($date))) && (strtotime(date("His"))>(strtotime(date($time)))-$lag) ) )
        return true;
    else
        return false;
}

//date interval for post news
function getDateInterval($date){
    $today = date("Y-m-d");
    $todayCreate = date_create($today);
    $post_date = date_create($date);
    $date_diff = date_diff($post_date,$todayCreate);
    $getDate = $date_diff -> format("%r%a");
    if($getDate==0){
        return "today at";
    }elseif($getDate==1){
        return $getDate."day ago at";
    }elseif($getDate>4){
        return dateString($date)." at";
    }else{
        return $getDate."days ago at";
    }
}

function displayView($value = 0, $view_array = [], $message='') {
    if($value != 0) {
        static $i = 1;
        $table = '<table class="table table-responsive table-bordered table-hover">';
        $table .= '<thead><tr style="color: #000;"><td>Index</td><td>Email Address</td></tr></thead><tbody>';
        $count = 1;
        foreach($view_array as $email) {
            $table .= "<tr><td>$count</td><td>$email</td></tr>";
            $count++;
        }
        $table .= '</tbody></table>';

        $data_target = "myModal_{$i}";
        $display = "<a href='' data-toggle='modal' data-target=#{$data_target}>View</a>";
        $display .= <<<EOT
        <div class='modal fade' id=$data_target tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h5 class='modal-title' id='myModalLabel' style='font-size: 25px'>$message</h5>
                    </div>
                    <div class='modal-body'>$table</div>
                </div>
            </div>
        </div>
EOT;
        $i++;
        return $display;
    }
    return '';
}

//function to wrap election_id
function wrap($num){
    return rand(1,9).rand(10,99).rand(10,99).rand(1000,9999).$num.rand(10000,99999).rand(100,999);
}
//function to unwrap
function unwrap($num){
    //this is still loading
    $ret=(string)$num;
    return substr($ret,9,strlen($ret)-17);
}

//function to get the name of a photo
function getPhotoName($photo){
    $photoName= explode('/',$photo);
    return $photoName[2];
}


//function to get separate year, month and day from date
function getDates($mydates){
    $resultDates = array();
    $datesResult= explode('-',$mydates);
    array_push($resultDates, $datesResult[0],$datesResult[1],$datesResult[2]);
    return $resultDates;
}

//function to get separate hour and minute from time
function getTime($mytime){
    $resultTime = array();
    $timeResult= explode(':',$mytime);
    array_push($resultTime, $timeResult[0],$timeResult[1]);
    return $resultTime;
}
//function to get the actual time
function getActualtime($input){

    $time= explode(":",$input);

    if ( count($time) == 3)
    {
        $hour=removeSpace($time[0]);

        if(removeSpace($time[2])=="PM"){
            $hour+=12;
        }
        if($hour==24){
            $hour="00";
        }
        return $hour.":".removeSpace($time[1]).":00";
    }else{
        return "00:00:00";
    }

}

//lets write a function to handle mail sending
function sendEmail($recipient_address,$recipient_name,$subject,$body,$AltBody = "")
{
    //instantiate mailer class
    $mail = new PHPMailer;
    //Enable SMTP debugging.
//    $mail->SMTPDebug = 3;
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();
    //Set SMTP host name
    $mail->Host = "smtp.gmail.com";
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password
    $mail->Username = "oauevoting@gmail.com";
    $mail->Password = "webo2016";
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "tls";
    //Set TCP port to connect to
    $mail->Port = 587;

    $mail->From = "noreply@evoting.oauife.edu.ng";
    $mail->FromName = "OAU E-voting system.";
    $mail->addReplyTo("noreply@evoting.oauife.edu.ng");
    $mail->addAddress($recipient_address, $recipient_name);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $AltBody;

    if ($mail->send()) {
        return true;
    }else {
        return false;
    }

}

sendEmail("gabrieloyetunde@gmail.com","gabriel",'test','nice job');