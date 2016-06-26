<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/29/16
 * Time: 3:22 PM
 */
//session_start();
//include_once("connection.php");
$error_msg = '';
if (isset($_POST['join']) || isset($_POST['request'])) {
    $user_id=$_SESSION['user_id'];
    $election_id=$_SESSION['election_id'];

    if(isset($_POST['join'])){
        //prevent this user from doing this the second time
        if(attached('joined',$user_id,$election_id) == 'joined'){
            $error_msg ='<span class="error">You have already joined this election. Reload your main
                                            browser to see the effect.
                         </span>';
        }else{
            $connection1->query("INSERT INTO joined(user_id,election_id) VALUES ('$user_id','$election_id')");
            header("Location:status_accept.php");
        }

    }elseif(isset($_POST['request'])){
        //prevent this user from doing this the second time
        if (attached('request',$user_id,$election_id) == 'request') {
            $error_msg ='<span class="error">Your request has been processed. Reload your main
                                            browser to see the effect.
                         </span>';
        }else {
            $connection1->query("INSERT INTO request(user_id,election_id) VALUES ('$user_id','$election_id')");
            header("Location:request_sent.php");
        }

    }
    if ($error_msg == '') {
        die();
    }

}
