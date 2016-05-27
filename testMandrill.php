<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 3/9/16
 * Time: 9:59 AM
 */

include_once('vendor/mandrill/mandrill/src/Mandrill.php');
$mandrill= new Mandrill('3ZeSXbCg9LF7X1yXEmWY-A');
$message = new stdClass();
$user_id=1726272;
$name="Odumuyiwa Leye";
$recipient_mail="adekunlegenius2@gmail.com";
$message->html="Hello".$name.".<br>This is to notify you that your email address has been used to create an
                 account with us. Kindly ignore this mail if your account was used without your consent.
                 If not, click this link to activate your eVoting account.
                 (The redirecting is working fine right now. All i am left with is to check if the provided
                 email truly exists on the mail server.)
                <a href='localhost/E-voting/php/try2.php?confirm_me=".$user_id."'>Activate account.</a>";
$message->text="text body";
$message->subject="Activate your E-Voting account.";
$message->from_email="gabrieloyetunde@gmail.com";
$message->from_name="OAU E-Voting";
$message->to=array(array("email"=>$recipient_mail));
$message->track_open=true;
$send=$mandrill->messages->send($message);
if($send){
    echo("successfully sent");
}else{
    echo("not sent");
}
